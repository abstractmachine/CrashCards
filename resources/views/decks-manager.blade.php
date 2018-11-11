@extends('layouts.app')

@section('content')

    <div class="container p-3" id="app">

        <div class="row">
            <div class="col border-dark border">
                
                <h3>Decks</h3>
                <p>{{ $decks->toJson() }}</p>
                <deck-bag :decks="{{ $decks->toJson() }}"
                            url-ajax="{{ route('decks-manager') }}" 
                            @if(Auth::check())
                                :author="{{ Auth::user()->toJson() }}"
                            @endif
                            >                
                </deck-bag>

            </div>
        </div>
        
    </div>
    
@endsection
