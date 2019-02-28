<ul class="list-group">
    @foreach($workers as $worker)
        @php ($count_subs = count($worker->subordinates))
        <li class="list-group-item d-flex align-items-center">
            @if($count_subs > 0 && $current === $depth)
            <a href="javascript:ajaxLoad('{{ route('home', ['id' => $worker->id]) }}', '#subs{{ $worker->id }}')"
               class="collapser">
            @endif
                {{ $worker->full_name }} <span class="badge badge-danger ml-2">Профессия: <i>{{ $worker->job }}</i></span>
                @if($count_subs > 0)
                    <span class="badge badge-primary badge-pill ml-3">{{ count($worker->subordinates) }}</span>
                @endif
            @if($count_subs > 0 && $current === $depth)
            </a>
            @endif
        </li>
        <div id="subs{{ $worker->id }}" class="collapse"></div>
        @if($count_subs > 0)
            @if($current < $depth)
                @include('parts.tree.list', ['workers' => $worker->subordinates, 'current' => $current+1, 'depth' => $depth])
            @endif
        @endif
    @endforeach
</ul>
