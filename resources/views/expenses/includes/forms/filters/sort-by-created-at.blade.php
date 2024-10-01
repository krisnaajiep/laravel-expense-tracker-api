<form action="{{ route('expenses.index') }}" method="GET">
    @include('expenses.includes.forms.inputs.hidden-date-range')
    @if (request('order_by_amount'))
        <input type="hidden" name="order_by_amount" value="{{ request('order_by_amount') }}">
    @endif
    @if (request('order_by_date'))
        <input type="hidden" name="order_by_date" value="{{ request('order_by_date') }}">
    @endif
    <li>
        <button class="dropdown-item" type="submit" name="order_by_created_at"
            value="{{ request('order_by_created_at') === 'desc' ? 'asc' : 'desc' }}">
            Created at
            @if (request('order_by_created_at'))
                <i
                    class="bi bi-sort-numeric-{{ request('order_by_created_at') === 'desc' ? 'down' : 'up' }} float-end"></i>
            @endif
        </button>
    </li>
</form>
