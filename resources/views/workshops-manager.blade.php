@extends('layouts.app')

@section('content')

    <div class="container p-3" id="app">

        <div class="row">
            <div class="col border-dark border">
                
                <h3>Workshops</h3>
                
                <workshops-register 
                            :workshops="{{ $workshops->toJson() }}"
                            url-ajax="{{ route('workshops-manager') }}" 
                            @if(Auth::check())
                                :author="{{ Auth::user()->toJson() }}"
                            @endif
                            >                
                </workshops-register>

            </div>
        </div>
        
    </div>
    
@endsection
