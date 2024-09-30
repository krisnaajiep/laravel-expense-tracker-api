<x-layout>
    <x-navigation loggeduser="{{ $user->name }}" />

    <div class="container bg-body mt-5 p-4 rounded">
        @session('status')
            <div class="alert alert-{{ session('type') }}">
                {{ session('status') }}
            </div>
        @endsession
        <div class="row border-bottom pb-2 mb-2">
            <div class="col-8 pt-2">
                <h5>Your Expenses {{ $filter_request }}</h5>
            </div>
            <div class="col-4 text-end">
                <div class="dropdown d-inline">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Filter
                    </button>
                    <ul class="dropdown-menu">
                        <form action="{{ route('expenses.index') }}" method="GET">
                            <li>
                                <button class="dropdown-item" type="submit" name="start_date" value="past_week">
                                    Past Week
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item" type="submit" name="start_date" value="last_month">
                                    Last Month
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item" type="submit" name="start_date" value="last_3_months">
                                    Last 3 Months
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#customFilterModal">
                                    Custom
                                </button>
                            </li>
                        </form>
                    </ul>
                    @include('expenses.includes.custom-filter')
                </div>
                <a href="#" class="btn btn-success">Add New Expense</a>
            </div>
        </div>
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
                @forelse ($expenses as $expense)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>Rp {{ $expense->amount }}</td>
                        <td>{{ $expense->category }}</td>
                        <td>{{ $expense->date_time }}</td>
                        <td class="text-center">{{ $expense->payment_method }}</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-primary btn-sm">View</a>
                            <a href="#" class="btn btn-warning btn-sm">Edit</a>
                            <form action="#" method="post" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="6">Not found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
