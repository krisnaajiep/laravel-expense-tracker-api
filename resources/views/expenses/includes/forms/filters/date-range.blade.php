<form action="{{ route('expenses.index') }}" method="GET">
    @include('expenses.includes.forms.inputs.hidden-sort-by')
    <li>
        <button class="dropdown-item {{ request('start_date') === 'past_week' ? 'active' : '' }}" type="submit"
            name="start_date" value="past_week">
            Past Week
        </button>
    </li>
    <li>
        <button class="dropdown-item {{ request('start_date') === 'last_month' ? 'active' : '' }}" type="submit"
            name="start_date" value="last_month">
            Last Month
        </button>
    </li>
    <li>
        <button class="dropdown-item {{ request('start_date') === 'last_3_months' ? 'active' : '' }}" type="submit"
            name="start_date" value="last_3_months">
            Last 3 Months
        </button>
    </li>
    <li>
        <button type="button" class="dropdown-item {{ request('custom') === 'on' ? 'active' : '' }}"
            data-bs-toggle="modal" data-bs-target="#customDateRangeFilterModal">
            Custom
        </button>
    </li>
</form>
