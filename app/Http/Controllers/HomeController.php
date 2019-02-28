<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Worker;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        $workers = Worker::where('chief_id', 0)->get();
        $depth = 2;

        if ($request->ajax() ) {
            $worker = Worker::find((int)$request->id);
            if ($worker !== null) {
                return view('parts.tree.list', ['workers' => $worker->subordinates, 'current' => 0, 'depth' => 0]);
            }
        }
        return view('home', compact('workers', 'depth'));
    }
}
