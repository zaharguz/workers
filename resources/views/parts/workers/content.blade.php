<h1 class="h1 text-center m-3">Список сотрудников</h1>
<div class="col-10 offset-1">
    <div class="row">
        <div class="col-8">
            @if(request()->session()->get('search') !== '')
            <p>Показаны результаты поиска по <b>{{ request()->session()->get('search') }}</b>
                <a href="javascript:ajaxLoad('{{ route('workers', ['reset_search' => 1]) }}')">сбросить</a>
            </p>
            @endif
        </div>
        <div class="col-4">
            <form class="form-inline float-right" action="{{ route('workers') }}" onsubmit="event.preventDefault();">
                <input id="search" class="form-control mr-sm-2" type="search" placeholder="Поиск" aria-label="Search"
                       name="search" value="{{ request()->session()->get('search') }}"
                       onkeydown="if (event.keyCode === 13) ajaxLoad('{{ route('workers') }}?search='+this.value)">
                <button class="btn btn-outline-info my-2 my-sm-0" type="submit"
                        onclick="ajaxLoad('{{ route('workers') }}?search='+$('#search').val())">Искать</button>
            </form>
        </div>
    </div>
    <div class="table-responsive mt-3">
        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th>
                    <a href="javascript:ajaxLoad('{{ route('workers', ['sort_field' => 'id', 'sort_type' => (request()->session()->get('sort_type') === 'asc') ? 'desc' : 'asc']) }}')"
                       class="text-white">#</a>
                    @if(request()->session()->get('sort_field') === 'id') {!! request()->session()->get('sort_type') === 'asc' ? '&#9652;' : '&#9662;' !!} @endif
                </th>
                <th>
                    <a href="javascript:ajaxLoad('{{ route('workers', ['sort_field' => 'full_name', 'sort_type' => (request()->session()->get('sort_type') === 'asc') ? 'desc' : 'asc']) }}')"
                       class="text-white">ФИО</a>
                    @if(request()->session()->get('sort_field') === 'full_name') {!! request()->session()->get('sort_type') === 'asc' ? '&#9652;' : '&#9662;' !!} @endif
                </th>
                <th>
                    <span>Фото</span>
                </th>
                <th>
                    <a href="javascript:ajaxLoad('{{ route('workers', ['sort_field' => 'job', 'sort_type' => (request()->session()->get('sort_type') === 'asc') ? 'desc' : 'asc']) }}')"
                       class="text-white">Должность</a>
                    @if(request()->session()->get('sort_field') === 'job') {!! request()->session()->get('sort_type') === 'asc' ? '&#9652;' : '&#9662;' !!} @endif
                </th>
                <th>
                    <a href="javascript:ajaxLoad('{{ route('workers', ['sort_field' => 'salary', 'sort_type' => (request()->session()->get('sort_type') === 'asc') ? 'desc' : 'asc']) }}')"
                       class="text-white">З/П</a>
                    @if(request()->session()->get('sort_field') === 'salary') {!! request()->session()->get('sort_type') === 'asc' ? '&#9652;' : '&#9662;' !!} @endif
                </th>
                <th>
                    <a href="javascript:ajaxLoad('{{ route('workers', ['sort_field' => 'hire_date', 'sort_type' => (request()->session()->get('sort_type') === 'asc') ? 'desc' : 'asc']) }}')"
                       class="text-white">Дата трудоустройства</a>
                    @if(request()->session()->get('sort_field') === 'hire_date') {!! request()->session()->get('sort_type') === 'asc' ? '&#9652;' : '&#9662;' !!} @endif
                </th>
                <th>
                    <a href="javascript:ajaxLoad('{{ route('workers', ['sort_field' => 'chief_id', 'sort_type' => (request()->session()->get('sort_type') === 'asc') ? 'desc' : 'asc']) }}')"
                       class="text-white">ФИО начальника</a>
                    @if(request()->session()->get('sort_field') === 'chief_id') {!! request()->session()->get('sort_type') === 'asc' ? '&#9652;' : '&#9662;' !!} @endif
                </th>
                <th scope="col">
                    <span class="mr-5">Действия</span>
                    <a href="javascript:ajaxLoadModal('{{ route('create_worker') }}', '#modalContainer .modal-body')" class="btn btn-success btn-sm">Добавить</a>
                </th>
            </tr>
            </thead>
            <tbody id="workers-table-content">
            @include('parts.workers.loop')
            </tbody>
        </table>
    </div>
    <div class="pagination justify-content-center">
        {{ $workers->links() }}
    </div>
</div>