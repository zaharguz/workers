<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Worker;

class HomeController extends Controller
{
    /**
     * Show front page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $workers = Worker::where('chief_id', 0)->get();
        $depth = 2;

        return view('home', compact('workers', 'depth'));
    }
}
