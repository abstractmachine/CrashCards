@extends('layouts.app')

@section('content')

    <div class="container p-3" id="app">

        <div class="row">
            <div class="col-3 border-right">
                <h3>Workhops</h3>
                @foreach ($workshops as $workshop)
                    <p>{{ $workshop->name }}</p>
                @endforeach 
            </div>

            <div class="col border-dark border">
                <h1>{{ $currentWorkshop->name}}</h1>
                <h3>{{ $currentWorkshop->author->username}}</h3>

                @if(count($currentWorkshop->links))
                    <h5>Links:</h5>
                    <ul>
                        @foreach ($currentWorkshop->links as $link)
                            <p><a href=" {{ $link->url }}">{{ $link->title }}</a></p>
                        @endforeach
                    </ul>
                @endif

                @isset($currentWorkshop->deck)
                    <board :deck="{{ $currentWorkshop->deck->toJson() }}"></board>
                    <board :deck="{{ $currentWorkshop->deck->toJson() }}"></board>
                @else
                    <p>there is no deck selected</p>
                @endisset
            </div>
        </div>
        
    </div>
    
@endsection
