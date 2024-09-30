<x-layout>
    <x-navigation loggeduser="{{ $user->name }}" />

    <div class="container bg-body my-5 p-4 rounded">
        @session('status')
            <div class="alert alert-{{ session('type') }}">
                {{ session('status') }}
            </div>
        @endsession
        <h5>{{ __('Edit Profile') }}</h5>
        <hr>
        <form action="{{ route('profile.update') }}" method="POST" class="w-50 mb-5">
            @method('PUT')
            @csrf
            <x-forms.input type="text" name="name" class="mb-3"
                value="{{ old('name', $user->name) }}">Name</x-forms.input>
            <x-forms.input type="email" name="email" class="mb-3"
                value="{{ old('email', $user->email) }}">Email</x-forms.input>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
        <h5>{{ __('Edit Password') }}</h5>
        <hr>
        <form action="{{ route('password.update') }}" method="POST" class="w-50 mb-5">
            @method('PUT')
            @csrf
            <x-forms.input type="password" name="current_password" class="mb-3" value="">
                Current Password</x-forms.input>
            <x-forms.input type="password" name="password" class="mb-3" value="">Password</x-forms.input>
            <x-forms.input type="password" name="password_confirmation" class="mb-4" value="">
                Password Confirmation</x-forms.input>
            <button type="submit" class="btn btn-primary">Update Password</button>
        </form>
        <h5>{{ __('Delete Account') }}</h5>
        <hr>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger mb-5" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
            Delete Account
        </button>
        @include('profile.includes.delete')
    </div>
</x-layout>
