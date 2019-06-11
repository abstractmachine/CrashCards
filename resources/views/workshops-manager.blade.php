@section('title', 'Workshops Manager')

@extends('layouts.app')

@section('content')

    <div class="p-3" id="app">
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
    
@endsection
