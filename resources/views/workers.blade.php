@extends('layouts.app')

@section('title', 'Workers')

@section('content')
    <h1 class="h1 text-center m-3">Список сотрудников</h1>
    <div id="workers" class="container-fluid">
        @include('parts.workers_content')
    </div>
@endsection

@section('script')
    <script>
        $(document).on('click', '.pagination a.page-link', function (event) {
            event.preventDefault();
            ajaxLoad($(this).attr('href'));
        });

        function ajaxLoad(filename, content) {
            content = typeof content !== 'undefined' ? content : 'workers';
            $('#loading').show();
            $.ajax({
                type: "GET",
                url: filename,
                contentType: false,
                success: function (data) {
                    $("#" + content).html(data);
                    $('#loading').hide();
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        }
    </script>
@endsection