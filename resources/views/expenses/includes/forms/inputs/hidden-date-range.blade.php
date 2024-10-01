@if (request('start_date'))
    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
@endif
@if (request('end_date'))
    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
@endif
@if (request('custom'))
    <input type="hidden" name="custom" value="on">
@endif
