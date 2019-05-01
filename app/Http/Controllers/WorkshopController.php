<?php

namespace App\Http\Controllers;

use App\Deck;
use App\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkshopController extends Controller
{
    //
    public function __construct()
    {
        // $this->middleware('auth');
    }


    public function destroy(Request $request)
    {
        if ($request->ajax()) {

            $request->validate([
                '_data.id' => 'required',
                '_data.author' => 'required',
            ]);

            $user = Auth::user();
            $deckUser = User::find($request->_data['author']['id']);

            if($deckUser->id == $user->id){

                $deck = Deck::find($request->_data['id']);
                $deck->delete();

                return 'true';
            }else{
                return 'false';
            }
        }
    }

    public function create(Request $request)
    {
        $user = Auth::user();

        $workshop = new Workshop();
        $workshop->save();
        $workshop->author()->associate($user);
        $workshop->save();

        return redirect()->route('workshop-entry', compact('workshop')); 

    }


    public function index()
    {
        $workshops = Workshop::all();

        $currentWorkshop = $this->getWorkshopState(Workshop::first());

        return view('home', compact('workshops', 'currentWorkshop'));
    }

    public function indexWorkshops()
    {
        $workshops = Workshop::all();
        $workshops->load('author');

        return view('workshops-manager', compact('workshops'));
    }

    public function indexWorkshop(Workshop $workshop, Request $request)
    {
        $workshop->load('author');
        $decks = Deck::all();
        return view('workshop-entry', compact('workshop', 'decks'));
    }

    public function updateWorkshop(Workshop $workshop, Request $request){

        if ($request->ajax()) {

            $request->validate([
                '_data.id' => 'required|numeric',
            ]);

            $user = Auth::user();

            if($workshop->author->id == $user->id){

                $workshop->name = $request->_data['name'];
                $workshop->save();

                return 'true';
            }else{
                return 'false';
            }
        }
    }


    function getWorkshopState(){
    	return Workshop::findOrFail(1)
        				->load('deck.categories', 'deck.cards');
    }
}
