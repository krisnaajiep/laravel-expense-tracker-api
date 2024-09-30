<x-layout>
    <x-navigation loggeduser="{{ $user->name }}" />

    <div class="container bg-body mt-5 p-4 rounded">
        @session('status')
            <div class="alert alert-{{ session('type') }}">
                {{ session('status') }}
            </div>
        @else
            {{ __('You are logged in') }}
        @endsession
    </div>
</x-layout>
