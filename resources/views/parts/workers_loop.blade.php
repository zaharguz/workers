@foreach($workers as $worker)
    <tr>
        <th scope="row">{{ $worker->id }}</th>
        <td>{{ $worker->full_name }}</td>
        <td>{{ $worker->job }}</td>
        <td>${{ $worker->salary }}</td>
        <td>{{ Carbon\Carbon::parse($worker->hire_date)->format('d.m.Y') }}</td>
        <td>{{ $worker->chief->full_name ?? '' }}</td>
        <td>
            <div class="btn-group">
                <a href="#" class="btn btn-info btn-sm">Показать</a>
                <a href="#" class="btn btn-warning btn-sm">Редактировать</a>
                <a href="#" class="btn btn-danger btn-sm">Удалить</a>
            </div>
        </td>
    </tr>
@endforeach