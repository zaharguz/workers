@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h1 class="h1 text-center m-3">Иерархия сотрудников в древовидной форме</h1>
    <div class="home container">
        @include('parts.tree.list', ['workers' => $workers, 'current' => 0, 'depth' => $depth])
    </div>
@endsection