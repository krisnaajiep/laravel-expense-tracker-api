<x-layout>
    <div class="d-flex flex-column justify-content-center" style="height: 100vh">
        <div class="card mx-auto mb-4" style="width:30rem">
            <div class="card-body">
                <h3 class="text-center mb-4">Register Form</h3>
                <form action="/auth/register" method="POST">
                    @csrf
                    <x-forms.input type="text" name="name" class="mb-3"
                        value="{{ old('name') }}">Name</x-forms.input>
                    <x-forms.input type="email" name="email" class="mb-3"
                        value="{{ old('email') }}">Email</x-forms.input>
                    <x-forms.input type="password" name="password" class="mb-3"
                        value="">Password</x-forms.input>
                    <x-forms.input type="password" name="password_confirmation" class="mb-4" value="">
                        Password Confirmation</x-forms.input>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
                <div class="text-center mt-3">
                    <a href="/auth/forgot-password" class="d-block"><small>Forgot Password?</small></a>
                    <a href="/auth/login"><small>Login now!</small></a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
