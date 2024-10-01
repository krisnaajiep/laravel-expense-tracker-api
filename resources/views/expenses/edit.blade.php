<x-layout>
    <x-navigation loggeduser="{{ $user->name }}" />

    <div class="container bg-body mt-5 p-4 rounded">
        @session('status')
            <div class="alert alert-{{ session('type') }}">
                {{ session('status') }}
            </div>
        @endsession
        <div class="pt-2 border-bottom pb-2 mb-2">
            <h5>Edit Expense</h5>
        </div>
        @include('expenses.includes.forms.edit.expense')
    </div>
</x-layout>
