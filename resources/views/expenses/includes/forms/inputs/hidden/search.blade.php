@if (request('start_date'))
    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
@endif
@if (request('end_date'))
    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
@endif
@if (request('order_by_amount'))
    <input type="hidden" name="order_by_amount" value="{{ request('order_by_amount') }}">
@endif
@if (request('order_by_date'))
    <input type="hidden" name="order_by_date" value="{{ request('order_by_date') }}">
@endif
@if (request('order_by_created_at'))
    <input type="hidden" name="order_by_created_at" value="{{ request('order_by_created_at') }}">
@endif