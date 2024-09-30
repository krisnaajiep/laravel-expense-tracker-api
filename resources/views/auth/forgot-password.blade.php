<x-layout>
    <div class="d-flex flex-column justify-content-center" style="height: 100vh">
        <div class="card mx-auto mb-4" style="width:25rem">
            <div class="card-body">
                <h3 class="text-center mb-1">Forgot Password</h3>
                <p class="text-center mb-4">Please enter your email address and we will send link to reset your password.
                </p>
                @session('status')
                    <div class="alert alert-{{ session('type') }}">
                        {{ session('status') }}
                    </div>
                @endsession
                <form action="/auth/forgot-password" method="POST">
                    @csrf
                    <x-forms.input type="email" name="email" class="mb-3"
                        value="{{ old('email') }}">Email</x-forms.input>
                    <button type="submit" class="btn btn-primary w-100 mb-2">Submit</button>
                </form>
                <div class="text-center mt-3">
                    <a href="/auth/login" class="d-block"><small>Login now!</small></a>
                    <a href="/auth/register"><small>Register now!</small></a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
