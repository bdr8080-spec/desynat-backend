@foreach ($sizes as $size => $info)
    <button class="size-btn" data-size="{{ $info->size_id }}">
        {{ $info->size->name  }}
    </button>
@endforeach


