<form action="{{ route('expenses.store') }}" method="POST" class="w-50 mb-4">
    @csrf
    <div class="row mb-3">
        <x-forms.input type="text" name="amount" class="col" value="{{ old('amount') }}">Amount</x-forms.input>
        <x-forms.input type="text" name="category" class="col"
            value="{{ old('category') }}">Category</x-forms.input>
    </div>
    <x-forms.textarea name="description" class="mb-3" value="">Description</x-forms.textarea>
    <div class="row mb-4">
        <x-forms.input type="datetime-local" name="date_time" class="col" value="{{ old('date_time') }}">
            Date</x-forms.input>
        <x-forms.input type="text" name="payment_method" class="col" value="{{ old('payment_method') }}">
            Payment Method</x-forms.input>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
