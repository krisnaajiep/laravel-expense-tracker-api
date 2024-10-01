<!-- Custom Date Range Filter Modal -->
<div class="modal fade" id="customDateRangeFilterModal" tabindex="-1" aria-labelledby="customDateRangeFilterModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="customDateRangeFilterModalLabel">Custom Date Range Filter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
                <form action="" method="get">
                    @include('expenses.includes.forms.inputs.hidden-sort-by')
                    <div class="row">
                        <div class="col">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="datetime-local" class="form-control" id="start_date" name="start_date"
                                aria-label="Start date" value="{{ request('start_date') }}">
                        </div>
                        <div class="col">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date"
                                aria-label="End date" value="{{ request('end_date') }}">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="custom" value="on">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
