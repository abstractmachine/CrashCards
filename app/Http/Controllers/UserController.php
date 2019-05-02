<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index(){
    	$user = Auth::user();
        return view('user', compact('user'));
    }
}
