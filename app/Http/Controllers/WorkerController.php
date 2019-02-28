<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Worker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class WorkerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $request->session()->put('search', $request
                ->get('search') ?? ((!$request->exists('reset_search') && $request->session()->has('search')) ? $request->session()->get('search') : ''));
        $request->session()->put('sort_field', $request
                ->get('sort_field') ?? $request->session()->get('sort_field') ?? 'id');
        $request->session()->put('sort_type', $request
                ->get('sort_type') ?? $request->session()->get('sort_type') ?? 'asc');

        $workers = new Worker;

        if ($request->session()->get('search') !== '') {
            $search = str_replace(' ', '%', $request->session()->get('search'));
            $workers = $workers->where('id', 'like', '%' . $search . '%')
                ->orWhere('full_name', 'like', '%' . $search . '%')
                ->orWhere('job', 'like', '%' . $search . '%')
                ->orWhere('salary', 'like', '%' . $search . '%')
                ->orWhere('hire_date', 'like', '%' . $search . '%');
        }

        $workers = $workers->orderBy($request->session()->get('sort_field'), $request->session()->get('sort_type'))
                ->paginate(50);

        if ($request->ajax()) {
            return view('parts.workers.content', compact('workers'));
        }
        return view('workers.index', compact('workers'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get')) {
            if ($request->ajax()) {
                return view('parts.workers.form', ['chiefs' => Worker::where('chief_id', 0)->pluck('id', 'full_name')]);
            }
            return view('workers.update', ['chiefs' => Worker::where('chief_id', 0)->pluck('id', 'full_name')]);
        }

        $rules = [
            'full_name' => 'required',
            'job' => 'required',
            'hire_date' => 'required',
            'salary' => 'required',
            'photo'         => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'chief_id' => 'required',
        ];

        $messages = [
            'full_name.required'    => 'Введите ФИО',
            'job.required'          => 'Введите должность работника',
            'hire_date.required'    => 'Укажите дату приема на работу',
            'salary.required'       => 'Введите размер зарплаты работника',
            'photo'                 => 'Неверный файл',
            'chief_id.required'     => 'Укажите начальника',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'fail' =>true,
                'errors' => $validator->errors()
            ]);
        }

        $worker = new Worker();
        $worker->full_name = $request->full_name;
        $worker->job = $request->job;
        $worker->hire_date = Carbon::parse($request->hire_date)->format('Y-m-d');
        $worker->salary = $request->salary;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('workers', 'public');
            $worker->photo = 'storage/' . $path;
        }
        if ((int)$request->chief_id === 0) {
            $worker->chief_id = 0;
            $worker->save();
        } else {
            $worker->chief()->associate(Worker::find((int)$request->chief_id));
        }
        $worker->save();

        return response()->json([
            'fail' => false,
            'redirect_url' => route('workers'),
        ]);
    }

    public function show(Request $request, $id)
    {
        if ($request->isMethod('get')) {
            if ($request->ajax()) {
                return view('parts.workers.details', ['worker' => Worker::find($id)]);
            }
            return view('workers.single', ['worker' => Worker::find($id)]);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('get')) {
            if ($request->ajax()) {
                return view('parts.workers.form',  ['worker' => Worker::find($id), 'chiefs' => Worker::where('chief_id', 0)->pluck('id', 'full_name')]);
            }
            return view('workers.update',  ['worker' => Worker::find($id), 'chiefs' => Worker::where('chief_id', 0)->pluck('id', 'full_name')]);
        }

        $rules = [
            'full_name'     => 'required',
            'job'           => 'required',
            'hire_date'     => 'required',
            'salary'        => 'required',
            'photo'         => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'chief_id'      => 'required',
        ];

        $messages = [
            'full_name.required'    => 'Введите ФИО',
            'job.required'          => 'Введите должность работника',
            'hire_date.required'    => 'Укажите дату приема на работу',
            'salary.required'       => 'Введите размер зарплаты работника',
            'photo.image'           => 'Неверный файл',
            'photo.mimes'           => 'Неверный файл',
            'photo.max'             => 'Неверный файл',
            'chief_id.required'     => 'Укажите начальника',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'fail' =>true,
                'errors' => $validator->errors()
            ]);
        }

        $worker = Worker::find($id);
        $worker->full_name = $request->full_name;
        $worker->job = $request->job;
        $worker->hire_date = Carbon::parse($request->hire_date)->format('Y-m-d');
        $worker->salary = $request->salary;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('workers', 'public');
            $worker->photo = 'storage/' . $path;
        }
        if ((int)$request->chief_id === 0) {
            $worker->chief_id = 0;
        } else {
            $worker->chief()->associate(Worker::find((int)$request->chief_id));
        }
        $worker->save();

        if ($request->ajax()) {
            return response()->json([
                'fail' => false,
                'redirect_url' => route('workers')
            ]);
        }
        return redirect('workers');
    }

    public function destroy(Request $request, $id)
    {
        $worker = Worker::find($id);
        $worker->chief->subordinates()->saveMany($worker->subordinates);
        $worker->delete();
        if ($request->ajax()) {
            return response()->json([
                'fail' => false,
                'redirect_url' => route('workers')
            ]);
        }
        return redirect('workers');
    }

    public function find(Request $request)
    {
        $search = str_replace(' ', '%', $request->search);
        $workers = Worker::where('full_name', 'like', '%' . $search . '%')->take(10)->pluck('full_name', 'id')->toJson();
        return response()->json($workers);
    }

}
