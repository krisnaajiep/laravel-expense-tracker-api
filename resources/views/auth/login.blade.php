<x-layout>
    <div class="d-flex flex-column justify-content-center" style="height: 100vh">
        <div class="card mx-auto mb-4" style="width:25rem">
            <div class="card-body">
                <h3 class="text-center mb-4">Login Form</h3>
                @session('status')
                    <div class="alert alert-{{ session('type') }}">
                        {{ session('status') }}
                    </div>
                @endsession
                <form action="/auth/login" method="POST">
                    @csrf
                    <x-forms.input type="email" name="email" class="mb-3"
                        value="{{ old('email') }}">Email</x-forms.input>
                    <x-forms.input type="password" name="password" class="mb-4"
                        value="">Password</x-forms.input>
                    <button type="submit" class="btn btn-primary w-100 mb-2">Login</button>
                </form>
                <div class="text-center mt-3">
                    <a href="/auth/forgot-password" class="d-block"><small>Forgot Password?</small></a>
                    <a href="/auth/register"><small>Register now!</small></a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
