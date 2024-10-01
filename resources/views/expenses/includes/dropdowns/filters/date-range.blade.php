<div class="dropdown d-inline">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Date Range
    </button>
    <ul class="dropdown-menu">
        @include('expenses.includes.forms.filters.date-range')
    </ul>
    @include('expenses.includes.modals.filters.custom-date-range')
</div>
