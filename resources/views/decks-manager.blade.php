@section('title', 'Decks Manager')

@extends('layouts.app')

@section('content')

    <h2 class="page-title">Decks</h2>
    
    <deck-bag :decks="{{ $decks->toJson() }}"
                url-ajax="{{ route('decks-manager') }}" 
                @if(Auth::check())
                    :author="{{ Auth::user()->toJson() }}"
                @endif
                >                
    </deck-bag>
    
@endsection
