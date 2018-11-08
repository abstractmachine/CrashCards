<?php

namespace App\Http\Controllers;



use App\Workshop;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $workshops = Workshop::all();

        // dd($workshops);

        return view('welcome', compact('workshops'));
    }
}
