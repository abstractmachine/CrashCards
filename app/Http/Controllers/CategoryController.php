<?php

namespace App\Http\Controllers;

use App\Category;
use App\Deck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    //

    public function saveName(Request $request){

        if ($request->ajax()) {

            $request->validate([
                '_data.id' => 'required',
                '_data.deck_id' => 'required',
            ]);

            $user = Auth::user();
            $category = Category::find($request->_data['id']);
            $deck = Deck::find($request->_data['deck_id']);

            if($deck->author->id == $user->id){

                $category->name = $request->_data['name'];
                $category->save();

                return $category->name;
            }else{
                return 'false';
            }
        }
    }

    public function destroy(Request $request, Category $category){

        if ($request->ajax()) {

            $request->validate([
                '_data.id' => 'required',
            ]);

            $user = Auth::user();
            $deck = Deck::find($request->_data['id']);

            if($deck->author->id == $user->id){

            	Category::destroy($category->id);
                return 'true';
            }else{
                return 'false';
            }
        }

    }
}
