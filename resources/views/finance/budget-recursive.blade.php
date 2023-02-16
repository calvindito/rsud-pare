@foreach($sub as $s)
    @if($s->sub->count() > 0)
        <tr>
            <td colspan="3">
                <span style="margin-left:{{ $left }}px;">{{ $s->name }}</span>
            </td>
        </tr>

        @include('finance.budget-recursive', ['sub' => $s->sub, 'left' => $left * 2, 'budget' => $budget, 'disabled' => $disabled])
    @else
        <tr>
            <input type="hidden" name="bd_chart_of_account_id[]" value="{{ $s->id }}">
            <td>
                <span style="margin-left:{{ $left }}px;">{{ $s->name }}</span>
            </td>
            <td>
                <input type="text" class="form-custom number-format" name="bd_nominal[]" value="{{ isset($budget) ? $budget->budgetDetail()->firstWhere('chart_of_account_id', $s->id)->nominal ?? '' : '' }}" placeholder="0" {{ $disabled ? 'disabled' : '' }}>
            </td>
            <td>
                <input type="text" class="form-custom number-format" name="bd_limit_blud[]" value="{{ isset($budget) ? $budget->budgetDetail()->firstWhere('chart_of_account_id', $s->id)->limit_blud ?? '' : '' }}" placeholder="0" {{ $disabled ? 'disabled' : '' }}>
            </td>
        </tr>
    @endif
@endforeach
