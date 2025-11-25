   @php 
     $iprice = 0;
    @endphp


@foreach ($sizes as $size => $info)
    <button class="size-btn {{ $iprice == 0 ? 'active' : '' }}" data-size="{{ $info->size_id }}">
        {{ $info->size->name  }}
    </button>
    
     @php $iprice++;
         @endphp

@endforeach


