<?php

namespace App\Http\Controllers;

use App\Card;
use App\Category;
use App\Deck;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeckController extends Controller
{

    //     ____            __
    //    / __ \___  _____/ /_______
    //   / / / / _ \/ ___/ //_/ ___/
    //  / /_/ /  __/ /__/ ,< (__  )
    // /_____/\___/\___/_/|_/____/

    public function index()
    {   
        if(Auth::check()){
            $user = Auth::user();
        }
        else{
            $user = false;
        }
        
        $decks = Deck::all()->load('author');

        foreach ($decks as $key => $deck) {
            if(!isset($deck->author))
                Deck::destroy($deck->id);
        }

        
        return view('decks-manager', compact('decks', 'user'));
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
        if(!Auth::check()){
            back();
        }

        $user = Auth::user();

        $deck = new Deck();
        $deck->save();
        $deck->author()->associate($user);
        $deck->save();

        return redirect()->route('deck-manager', compact('deck')); 

    }

    public function update(Request $request, Deck $deck){

        if ($request->ajax() && isset($deck) && Auth::check()) {

            $user = Auth::user();
            // $deckUser = User::find($request->_data['author']['id']);

            $request->validate([
                '_data' => 'required'
            ]);

            $deck->name = $request->_data["name"];
            $deck->save();

            return 'true';
        }

        return 'false';

    }

    //     ____            __
    //    / __ \___  _____/ /__
    //   / / / / _ \/ ___/ //_/
    //  / /_/ /  __/ /__/ ,<
    // /_____/\___/\___/_/|_|

    public function indexDeck(Deck $deck){
        $user = null;

        $user = Auth::user();
        
        // if($deck->author->id != $user->id){
        //     return redirect()->route('decks-manager'); 
        // }
        
        $cards = Card::all()->load('decks');

        $deck->load('categories');
        $deck->load('cards');

        foreach ($deck->categories as $key => $category) {
            $category->cards = $deck->cards->where('pivot.category_id', $category->id);
        }

        return view('deck-manager', compact('deck', 'user', 'cards'));
    }

    public function addCategory(Request $request){

        if ($request->ajax()) {

            $request->validate([
                '_data.id' => 'required',
            ]);

            $user = Auth::user();
            $deck = Deck::find($request->_data['id']);

            if($deck->author->id == $user->id){
                $category = new Category();
                $category->save();

                $deck->categories()->save($category);

                $category->cards = collect([]);

                return $category;
            }else{
                return 'false';
            }
        }
    }

    public function detachCard(Deck $deck, Card $card, Category $category, Request $request){
        // card == pivot de la relation
        if ($request->ajax()) {

            $user = Auth::user();

            if($deck->author->id == $user->id){

                // $deck->cards->where('id', $card->id)->first()->detach();

                $pivotId = $card->decks()->wherePivot('category_id', $category->id)->get()->where('id', $deck->id)->first()->pivot->id;

                $deck->cards()
                     ->wherePivot('card_id', $card->id)
                     ->wherePivot('category_id', $category->id)
                     ->wherePivot('id', '=', $pivotId)
                     ->detach();

                // $category->items = [];

                return  'true';
            }else{
                return 'false';
            }
        }

    }
    public function saveCard(Deck $deck, Card $card, Category $category, Request $request){

        if ($request->ajax()) {

            $user = Auth::user();

            if($deck->author->id == $user->id){
                // $category->items = [];

                $deck->cards()->attach($card, ['category_id' => $category->id]);
                $deck->save();

                // $card->pivot->id = $deck;

                return $card;
            }else{
                return 'false';
            }
        }

    }



}
