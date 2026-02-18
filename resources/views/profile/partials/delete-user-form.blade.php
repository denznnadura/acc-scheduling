<section>
    <header class="card-header">
        <h2>Delete Account</h2>
        <p>Permanently delete your account and all associated data</p>
    </header>

    <div class="warning-box">
        <strong>Warning: This action is permanent!</strong>
        Once your account is deleted, all of its resources and data will be permanently deleted. A confirmation email
        will be sent to you before deletion.
    </div>

    <button type="button" class="danger-btn" onclick="confirmDeletion()">
        <i class='bx bx-trash'></i>
        Delete Account
    </button>

    <!-- Modal -->
    <div id="confirmUserDeletion"
        style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
        <div
            style="background: white; margin: 10% auto; padding: 32px; width: 90%; max-width: 500px; border-radius: 12px;">
            <h3 style="font-size: 18px; font-weight: 600; color: var(--text-primary); margin-bottom: 12px;">
                Are you sure you want to delete your account?
            </h3>
            <p style="font-size: 13px; color: var(--text-tertiary); margin-bottom: 20px;">
                Once your account is deleted, all of its resources and data will be permanently deleted. Please enter
                your password to confirm you would like to permanently delete your account.
            </p>

            <form method="POST" action="{{ route('profile.destroy') }}" id="deleteForm">
                @csrf
                @method('DELETE')

                <div style="margin-bottom: 16px;">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="delete_password" class="form-control"
                        placeholder="Enter your password" required>
                    @error('password', 'userDeletion')
                        <div style="font-size: 11px; color: #dc2626; margin-top: 4px;" id="password-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="danger-btn">
                        <i class='bx bx-trash'></i>
                        Delete Account
                    </button>
                    <button type="button" class="submit-btn" onclick="closeModal()">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        function confirmDeletion() {
            Swal.fire({
                title: 'Delete Account?',
                text: "This action cannot be undone! A confirmation email will be sent.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('confirmUserDeletion').style.display = 'block';
                }
            });
        }

        function closeModal() {
            document.getElementById('confirmUserDeletion').style.display = 'none';
            document.getElementById('delete_password').value = '';
        }

        // Show error toast if password is incorrect
        @error('password', 'userDeletion')
            document.getElementById('confirmUserDeletion').style.display = 'block';

            Swal.fire({
                icon: 'error',
                title: 'Incorrect Password',
                text: '{{ $message }}',
                confirmButtonColor: '#dc2626',
                timer: 5000,
                timerProgressBar: true
            });
        @enderror
    </script>
@endpush
