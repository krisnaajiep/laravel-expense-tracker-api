@if (request('order_by_amount'))
    <input type="hidden" name="order_by_amount" value="{{ request('order_by_amount') }}">
@endif
@if (request('order_by_date'))
    <input type="hidden" name="order_by_date" value="{{ request('order_by_date') }}">
@endif
@if (request('order_by_created_at'))
    <input type="hidden" name="order_by_created_at" value="{{ request('order_by_created_at') }}">
@endif
@if (request('search'))
    <input type="hidden" name="search" value="{{ request('search') }}">
@endif
