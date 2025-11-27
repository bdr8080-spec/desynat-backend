
@foreach ($sizes as $key1 => $item1)

<div class="d-flex align-items-center mb-1">
        <h4 class="fw-bold text-dark me-2">{{ $item1['final_price'] }} KD</h4>
        <del class="text-muted me-2">{{ $item1['actual_price'] }} KD</del>
        <span class="text-danger fw-semibold">
            {{ $item1['discount_value'] }} {{ $item1['discount_type']=='1'? '% off' : 'KD off' }}
        </span>
    </div>
    @endforeach



