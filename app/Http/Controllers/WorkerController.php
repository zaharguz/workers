<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Worker;

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
            return view('parts.workers_content', compact('workers'));
        }

        return view('workers', compact('workers'));
    }

}
