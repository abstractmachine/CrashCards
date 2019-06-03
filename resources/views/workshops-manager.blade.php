@extends('layouts.app')

@section('content')

    <div class="container p-3" id="app">

        <div class="row">
            <div class="col border-dark border">
                
                <h3>Workshops</h3>
                
                <workshops-register 
                            :workshops="{{ $workshops->toJson() }}"
                            base-url="{{ route('workshops-manager') }}" 
                            remove-url="{{ route('workshops-manager') }}" 
                            @if(Auth::check())
                                :user="{{ Auth::user()->toJson() }}"
                            @endif
                            >                
                </workshops-register>

            </div>
        </div>
        
    </div>
    
@endsection
