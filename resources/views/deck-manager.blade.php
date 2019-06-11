@section('title', 'Deck - ' . $deck->name)

@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-start">
{{--         <card-picker :cards="{{ $cards->toJson() }}"
                     base-url="{{ URL::to('/') }}" >
        </card-picker> --}}

        <deck-maker :deck="{{ $deck->toJson() }}"
                    :original-deck="{{ $deck->toJson() }}"
                    url-ajax="{{ route('deck-manager', ['deck' => $deck->id]) }}" 
                    base-url="{{ URL::to('/') }}"
                    base-url="{{ URL::to('/') }}" 
                    :author="{{ Auth::user()->toJson() }}"
                    :cards="{{ $cards->toJson() }}"
                    >                
        </deck-maker>
    </div>
    
@endsection
