@extends('layouts.app')

@section('title', 'Workers')

@section('content')
    <div id="workers" class="container-fluid">
        @include('parts.workers.content')
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalContainer" tabindex="-1" role="dialog" aria-labelledby="modalContainer" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <button type="button" class="close d-flex ml-auto mr-2 mt-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
@endsection