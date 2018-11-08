<?php

namespace App\Http\Controllers;

use App\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    //
    public function __construct()
    {
        // $this->middleware('auth');
    }

    function create(){

    }


    public function index()
    {
        $workshops = Workshop::all();

        $currentWorkshop = $this->getWorkshopState(Workshop::first());

        return view('home', compact('workshops', 'currentWorkshop'));
    }

    function getWorkshopState(){
    	return Workshop::findOrFail(1)
        				->load('deck.categories', 'deck.cards');
    }
}
