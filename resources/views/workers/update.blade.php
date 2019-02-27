@extends('layouts.app')

@section('title', 'Workers')

@section('content')
    <div id="workers">
        <div class="container mt-4">
            <div class="col-md-8 col-12 offset-md-2">
                @include('parts.workers.form')
            </div>
        </div>
    </div>
@endsection