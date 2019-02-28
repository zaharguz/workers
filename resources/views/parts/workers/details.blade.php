<h1>Информация о работнике</h1>
<hr/>
<form class="worker-form">
    <fieldset disabled>
        @if(isset($worker->photo))
        <div class="form-group row">
            <span class="col-form-label col-md-4 col-12">Фото</span>
            <div class="col-md-8 col-12">
                <img src="{{ $worker->photo }}" alt="worker photo" class="img-thumbnail rounded form-img">
            </div>
        </div>
        @endif

        <div class="form-group row">
            <label for="full_name" class="col-form-label col-md-4 col-12">ФИО</label>
            <div class="col-md-8 col-12">
                <input type="text" value="{{ $worker->full_name }}" id="full_name" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <label for="job" class="col-form-label col-md-4 col-12">Должность</label>
            <div class="col-md-8 col-12">
                <input type="text" value="{{ $worker->job }}" id="job" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <label for="hire_date" class="col-form-label col-md-4 col-12">Дата приёма на работу</label>
            <div class="col-md-8 col-12">
                <input type="text" value="{{ \Carbon\Carbon::parse($worker->hire_date)->format('d.m.Y') }}" id="hire_date"
                       class="input-date form-control">
            </div>
        </div>

        <div class="form-group row">
            <label for="salary" class="col-form-label col-md-4 col-12">Размер заработной платы</label>
            <div class="col-md-8 col-12">
                <input type="number" min="1" value="{{ $worker->salary }}" id="salary" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <label for="chief_id" class="col-form-label col-md-4 col-12">Начальник</label>
            <div class="col-md-8 col-12">
                <input type="text" value="{{ isset($worker->chief) ? $worker->chief->full_name : '' }}"
                       id="chief_id" class="form-control">
            </div>
        </div>
    </fieldset>
</form>