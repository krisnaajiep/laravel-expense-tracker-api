<form action="{{ route('expenses.update', ['expense' => $expense->id]) }}" method="POST" class="w-50 mb-4">
    @method('PUT')
    @csrf
    <div class="row mb-3">
        <x-forms.input type="text" name="amount" class="col"
            value="{{ old('amount', $expense->amount) }}">Amount</x-forms.input>
        <x-forms.input type="text" name="category" class="col" value="{{ old('category', $expense->category) }}"
            list="categoriesOptions">Category</x-forms.input>
        @include('expenses.includes.forms.datalists.categories-options')
    </div>
    <x-forms.textarea name="description" class="mb-3"
        value="{{ old('description', $expense->description) }}">Description</x-forms.textarea>
    <div class="row mb-4">
        <x-forms.input type="datetime-local" name="date_time" class="col"
            value="{{ old('date_time', $expense->date_time) }}">
            Date</x-forms.input>
        <x-forms.input type="text" name="payment_method" class="col"
            value="{{ old('payment_method', $expense->payment_method) }}" list="paymentMethodOptions">
            Payment Method</x-forms.input>
        @include('expenses.includes.forms.datalists.payment-method-options')
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
</form>
