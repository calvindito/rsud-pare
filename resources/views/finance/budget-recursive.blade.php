@foreach($sub as $s)
    @if($s->sub->count() > 0)
        <tr>
            <td>
                <span style="margin-left:{{ $left }}px;">{{ $s->name }}</span>
            </td>
            <td class="fw-bold" width="5%">Parent</td>
        </tr>

        @include('finance.budget-recursive', ['sub' => $s->sub, 'left' => $left * 2])
    @else
        <tr>
            <td>
                <span style="margin-left:{{ $left }}px;">{{ $s->name }}</span>
            </td>
            <td width="5%">
                <div class="form-check form-switch justify-content-center">
                    <input type="checkbox" class="form-check-input form-check-input-success" name="budgetable[]" value="{{ $s->id }}" {{ $s->budgetable ? 'checked' : '' }}>
                </div>
            </td>
        </tr>
    @endif
@endforeach
