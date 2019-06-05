@section('title', 'Profile')

@extends('layouts.app')

@section('content')

    <div class="container p-3" id="app">

        <div class="row">

            <div class="col border-dark border">
                <user-editor 
                    :user="{{ $user }}"
                    url-ajax="{{ route('update-user', ['user' => $user]) }}" >
                </user-editor>
            </div>
        </div>
        
    </div>
    
@endsection
