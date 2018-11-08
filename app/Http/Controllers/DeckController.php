<?php

namespace App\Http\Controllers;

use App\Deck;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeckController extends Controller
{
    public function index()
    {   
        $user = Auth::user();

        $decks = Deck::where('user_id', $user->id)->get()->load('author');
        
        return view('decks-manager', compact('decks'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {

            $request->validate([
                '_data.name' => 'required',
                '_data.author' => 'required',
            ]);

            $newDeck = new Deck();

            $newDeck->name = $request->_data['name'];
            $newDeck->save();
            $newDeck->author()->associate(User::find($request->_data['author']));
            $newDeck->save();

            return $newDeck;

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

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
