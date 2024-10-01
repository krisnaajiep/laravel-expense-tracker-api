<x-layout>
    <x-navigation loggeduser="{{ $user->name }}" />

    <div class="container bg-body mt-5 p-4 rounded">
        @session('status')
            <div class="alert alert-{{ session('type') }}">
                {{ session('status') }}
            </div>
        @endsession
        <div class="row border-bottom pb-2 mb-2">
            <div class="col pt-2">
                <h5>Your Expenses {{ $date_range_string }}</h5>
            </div>
            <div class="col text-end">
                @include('expenses.includes.dropdowns.filters.sort-by')
                @include('expenses.includes.dropdowns.filters.date-range')
                <a href="{{ route('expenses.create') }}" class="btn btn-success">Add New Expense</a>
            </div>
        </div>
        <p>Total Amount : Rp {{ $total_amount }}</p>
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Category</th>
                    <th scope="col">Date</th>
                    <th scope="col" class="text-center">Payment Method</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($expenses_data as $expense)
                    <tr>
                        <th scope="row">{{ $start_number + $loop->index }}.</th>
                        <td>Rp {{ $expense->amount }}</td>
                        <td>{{ $expense->category }}</td>
                        <td>{{ $expense->date_time }}</td>
                        <td class="text-center">{{ $expense->payment_method }}</td>
                        <td class="text-center">
                            <a href="{{ route('expenses.show', ['expense' => $expense->id]) }}"
                                class="btn btn-primary btn-sm">View</a>
                            <a href="{{ route('expenses.edit', ['expense' => $expense->id]) }}"
                                class="btn btn-warning btn-sm">Edit</a>
                            @include('expenses.includes.forms.delete.expense')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="6">Not found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $paginator->links() }}
    </div>
</x-layout>
