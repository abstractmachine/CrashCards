<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
    	$user = Auth::user();
        return view('user', compact('user'));
    }
    
    public function update(Request $request, User $user){
    	// $user = Auth::user();
     //    return view('user', compact('user'));

        if ($request->ajax()) {

            $request->validate([
                '_data' => 'required',
            ]);

            if($user->id == $request->_data['id']){
            	//update user
                $user->name = $request->_data['name'];
                $user->username = $request->_data['username'];
            	$user->save();
            	return $user;
            }
            else 
            	return false;
        }
        else 
        	return false;
    }
}
