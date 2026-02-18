<section>
    <header class="card-header">
        <h2>Update Password</h2>
        <p>Ensure your account is using a long, random password to stay secure</p>
    </header>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">Current Password</label>
            <input type="password" name="current_password" id="update_password_current_password" class="form-control"
                autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div style="font-size: 11px; color: #dc2626; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">New Password</label>
            <input type="password" name="password" id="update_password_password" class="form-control"
                autocomplete="new-password">
            @error('password', 'updatePassword')
                <div style="font-size: 11px; color: #dc2626; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" id="update_password_password_confirmation"
                class="form-control" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <div style="font-size: 11px; color: #dc2626; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="submit-btn">
            <i class='bx bx-lock'></i>
            Update Password
        </button>
    </form>
</section>

@push('scripts')
    <script>
        // Show toast notification if password was updated
        @if (session('status') === 'password-updated')
            Swal.fire({
                icon: 'success',
                title: 'Password Updated!',
                text: 'Your password has been changed successfully. A confirmation email has been sent.',
                confirmButtonColor: '#1e40af',
                timer: 5000,
                timerProgressBar: true
            });
        @endif
    </script>
@endpush
