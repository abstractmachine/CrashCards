<?php

namespace App\Http\Controllers;

use App\Card;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function index()
    {
        $cards = Card::all()->load('author');
        
        foreach ($cards as $key => $card) {
            $card->editMode = false;
        }
        return view('cards-manager', compact('cards'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {

            $request->validate([
                '_data.name' => 'required',
                '_data.subtitle' => 'required',
                '_data.author' => 'required',
            ]);

            $newCard = new Card();

            $newCard->name = $request->_data['name'];
            $newCard->subtitle = $request->_data['subtitle'];
            $newCard->save();
            $newCard->author()->associate(User::find($request->_data['author']));
            $newCard->save();
            $newCard = $newCard->load('author');
            $newCard->editMode = false;
            return $newCard;

        }

    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {

        if ($request->ajax()) {

            $request->validate([
                '_data.id' => 'required|numeric',
                '_data.name' => 'required',
                '_data.subtitle' => 'required',
                '_data.author' => 'required',
            ]);

            $user = Auth::user();
            $cardAuthor = User::find($request->_data['author']['id']);
            // return $request->_data['author'];

            if($cardAuthor->id == $user->id){

                $card = Card::find($request->_data['id']);
                $card->name = $request->_data['name'];
                $card->subtitle = $request->_data['subtitle'];
                $card->author()->associate($cardAuthor);
                $card->save();
                $card = $card->load('author');

                return $card ;

            }else{
                return 'false';
            }



        }
    }

    public function destroy(Request $request)
    {
        if ($request->ajax()) {

            $request->validate([
                '_data.id' => 'required',
                '_data.author' => 'required',
            ]);

            $user = Auth::user();
            $cardUser = User::find($request->_data['author']['id']);

            if($cardUser->id == $user->id){

                $card = Card::find($request->_data['id']);
                $card->delete();

                return 'true';
            }else{
                return 'false';
            }
        }
    }
}
