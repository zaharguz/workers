@foreach($workers as $worker)
    <tr>
        <th scope="row">{{ $worker->id }}</th>
        <td>{{ $worker->full_name }}</td>
        <td>
            @if(isset($worker->photo))
            <img src="{{ $worker->photo }}" alt="worker photo" class="img-thumbnail rounded table-img">
            @endif
        </td>
        <td>{{ $worker->job }}</td>
        <td>${{ $worker->salary }}</td>
        <td>{{ Carbon\Carbon::parse($worker->hire_date)->format('d.m.Y') }}</td>
        <td>{{ $worker->chief->full_name ?? '' }}</td>
        <td>
            <div class="btn-group">
                <a href="javascript:ajaxLoadModal('{{ route('show_worker', $worker->id) }}', '#modalContainer .modal-body')"
                   class="btn btn-info btn-sm">Показать</a>
                <a href="javascript:ajaxLoadModal('{{ route('update_worker', $worker->id) }}', '#modalContainer .modal-body')"
                   class="btn btn-warning btn-sm">Редактировать</a>
                <a href="javascript:if (confirm('Вы уверены?')) ajaxDelete('{{ route('delete_worker', $worker->id) }}','{{ csrf_token() }}')" class="btn btn-danger btn-sm">Удалить</a>
            </div>
        </td>
    </tr>
@endforeach