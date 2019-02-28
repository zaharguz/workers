<h1>{{ isset($worker) ? 'Редактирование' : 'Добавление' }} работника</h1>
<hr/>
@if(isset($worker))
<form action="{{ route('update_worker', [$worker->id]) }}" method="post" class="needs-validation worker-form" id="frm">
    {{ method_field('PUT') }}
@else
<form action="{{ route('create_worker') }}" method="post" class="needs-validation worker-form" id="frm">
@endif
    {{ csrf_field() }}
    <div class="form-group row">
        <label for="full_name" class="col-form-label col-md-4 col-12">ФИО</label>
        <div class="col-md-8 col-12">
            <input type="text" name="full_name" value="{{ $worker->full_name ?? '' }}" id="full_name"
                   class="form-control {{ ($errors->has('full_name')) ? ' is-invalid' : '' }}" required>
            <span id="error-full_name" class="invalid-feedback"></span>
        </div>
    </div>

    <div class="form-group row">
        <label for="job" class="col-form-label col-md-4 col-12">Должность</label>
        <div class="col-md-8 col-12">
            <input type="text" name="job" value="{{ $worker->job ?? '' }}" id="job"
                   class="form-control {{ $errors->has('job') ? ' is-invalid' : '' }}" required>
            <span id="error-job" class="invalid-feedback"></span>
        </div>
    </div>

    <div class="form-group row">
        <label for="hire_date" class="col-form-label col-md-4 col-12">Дата приёма на работу</label>
        <div class="col-md-8 col-12">
            <input type="text" name="hire_date"
                   value="{{ isset($worker->hire_date) ? \Carbon\Carbon::parse($worker->hire_date)->format('d.m.Y') : '' }}"
                   id="hire_date" class="input-date form-control {{ $errors->has('hire_date') ? ' is-invalid' : '' }}" required>
            <span id="error-hire_date" class="invalid-feedback"></span>
        </div>
    </div>

    <div class="form-group row">
        <label for="salary" class="col-form-label col-md-4 col-12">Размер заработной платы</label>
        <div class="col-md-8 col-12">
            <input type="number" min="1" name="salary" value="{{ $worker->salary ?? '' }}" id="salary"
                   class="form-control {{ $errors->has('salary') ? ' is-invalid' : '' }}" required>
            <span id="error-salary" class="invalid-feedback"></span>
        </div>
    </div>

    <div class="form-group row">
        <label for="photo" class="col-form-label col-md-4 col-12">Фото работника</label>
        <div class="col-md-8 col-12 row">
            @if(isset($worker->photo))
            <div class="col-md-4 col-12">
                <img src="{{ $worker->photo }}" alt="worker photo" class="img-thumbnail rounded img-fluid">
            </div>
            @endif
            <div class="col-md-8 col-12">
                <input type="file" name="photo" id="photo" class="form-control-file {{ $errors->has('salary') ? ' is-invalid' : '' }}">
                <span id="error-photo" class="invalid-feedback"></span>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="chief_id" class="col-form-label col-md-4 col-12">Начальник</label>
        <div class="col-md-8 col-12 selectpicker-container">
            <input type="hidden" id="find_worker" value="{{ route('find_worker') }}">
            <select class="form-control selectpicker {{ $errors->has('chief_id') ? ' is-invalid' : '' }}" name="chief_id"
                    id="chief_id" data-live-search="true" required>
                <option value="0">- Отсутствует -</option>
                @if(isset($worker->chief))
                    <option value="{{ $worker->chief->id }}" selected>{{ $worker->chief->full_name }}</option>
                    @if(isset($worker->chief->chief))
                        @foreach($worker->chief->chief->subordinates as $subworker)
                            @if($subworker->id !== $worker->chief->id)
                                <option value="{{ $subworker->id }}">{{ $subworker->full_name }}</option>
                            @endif
                        @endforeach
                    @else
                        @foreach($chiefs as $name => $id)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    @endif
                @else
                    @foreach($chiefs as $name => $id)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                @endif
            </select>
            <span id="error-chief_id" class="invalid-feedback"></span>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-4 col-12">
            <button type="submit" class="btn btn-primary btn-xs">Сохранить</button>
        </div>
    </div>
</form>