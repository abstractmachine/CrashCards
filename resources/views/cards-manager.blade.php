@extends('layouts.app')

@section('content')

    <div class="container p-3" id="app">

        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col d-flex">
                        <h3 class="page-title mb-3">Cards</h3>
                    </div>
                </div>
                
                <card-table :cards="{{ $cards->toJson() }}"
                            url-ajax="{{ route('cards-manager') }}" 
                            @if(Auth::check())
                                :author="{{ Auth::user()->toJson() }}"
                            @endif
                            >                
                </card-table>

            </div>
        </div>
        
    </div>
    
@endsection
