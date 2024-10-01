<div class="dropdown d-inline">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Sort By
    </button>
    <ul class="dropdown-menu">
        @include('expenses.includes.forms.filters.sort-by-amount')
        @include('expenses.includes.forms.filters.sort-by-date')
        @include('expenses.includes.forms.filters.sort-by-created-at')
    </ul>
</div>
