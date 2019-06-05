@section('title', 'Deck - ' . $deck->name)

@extends('layouts.app')

@section('content')

    <div class="container p-3" id="app">

        <div class="row">
            <div class="col-3 border border-danger">

                <card-picker :cards="{{ $cards->toJson() }}"
                             base-url="{{ URL::to('/') }}" >
                </card-picker>

            </div>
            <div class="col border-dark border">

                <h3>Deck</h3>
                
                <deck-maker :deck="{{ $deck->toJson() }}"
                            url-ajax="{{ route('deck-manager', ['deck' => $deck->id]) }}" 
                            base-url="{{ URL::to('/') }}" 
                            :author="{{ Auth::user()->toJson() }}"
                            >                
                </deck-maker>

            </div>
        </div>
        
    </div>
    
@endsection
