@extends('layouts.app')

@section('content')

    <div class="container p-3" id="app">

        <div class="row">
            <div class="col border-dark border">
                
                <h3>Workshop</h3>
                <workshop-entry 
                            :workshop="{{ $workshop->toJson() }}"
                            :decks="{{ $decks->toJson() }}"
                            url-ajax="{{ route('workshop-entry', compact('workshop')) }}" 
                            @if(Auth::check())
                                :author="{{ Auth::user()->toJson() }}"
                            @endif
                            >                
                </workshop-entry>

            </div>
        </div>
        
    </div>
    
@endsection
