<x-layout>
    <div class="d-flex flex-column justify-content-center" style="height: 100vh">
        <div class="card mx-auto mb-5" style="width:25rem">
            <div class="card-body">
                <p class="text-center mb-4">
                    Verify your email address by clicking on the link we just emailed to you. If you didn't receive the
                    email, we will gladly send you another.
                </p>
                @session('status')
                    <div class="alert alert-{{ session('type') }}">
                        {{ session('status') }}
                    </div>
                @endsession
                <form action="/auth/email/verification-notification" method="POST" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 mb-2">Resend Verification Email</button>
                </form>
                <form action="/auth/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary w-100 mb-2">Logout</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
