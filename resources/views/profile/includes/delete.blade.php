<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteAccountModalLabel">Delete Account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.destroy') }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <div class="text-center">
                        <i class="bi bi-exclamation-triangle-fill fs-1 text-danger"></i>
                        <h6 class="mb-4">Are you sure you want to delete your account permanently?</h6>
                    </div>

                    <x-forms.input type="password" name="password" class="mb-3" value="">
                        Enter Current Password</x-forms.input>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
