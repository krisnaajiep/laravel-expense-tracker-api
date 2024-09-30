<x-layout>
    <div class="d-flex flex-column justify-content-center" style="height: 100vh">
        <div class="card mx-auto mb-4" style="width:30rem">
            <div class="card-body">
                <h3 class="text-center mb-4">Reset Password</h3>
                @session('status')
                    <div class="alert alert-{{ session('type') }}">
                        {{ session('status') }}
                    </div>
                @endsession
                <form action="/auth/reset-password" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <x-forms.input type="email" name="email" class="mb-3"
                        value="{{ old('email') }}">Email</x-forms.input>
                    <x-forms.input type="password" name="password" class="mb-3"
                        value="">Password</x-forms.input>
                    <x-forms.input type="password" name="password_confirmation" class="mb-4" value="">
                        Password Confirmation</x-forms.input>
                    <button type="submit" class="btn btn-primary w-100">Reset</button>
                </form>
                <div class="text-center mt-3">
                    <a href="/auth/login" class="d-block"><small>Login now!</small></a>
                    <a href="/auth/register"><small>Register now!</small></a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
