<section>
    <header class="card-header">
        <h2>Profile Information</h2>
        <p>Update your account's profile information and email address</p>
    </header>

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}"
                required autofocus>
            @error('name')
                <div style="font-size: 11px; color: #dc2626; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control"
                value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div style="font-size: 11px; color: #dc2626; margin-top: 4px;">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div
                    style="margin-top: 12px; padding: 12px; background: #fef3c7; border: 1px solid #fcd34d; border-radius: 8px; font-size: 12px; color: #92400e;">
                    <strong>Email not verified.</strong>
                    <form method="POST" action="{{ route('verification.send') }}" style="display: inline;">
                        @csrf
                        <button type="submit"
                            style="color: #1e40af; text-decoration: underline; background: none; border: none; padding: 0; cursor: pointer;">
                            Click here to resend verification email
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <button type="submit" class="submit-btn">
            <i class='bx bx-save'></i>
            Save Changes
        </button>
    </form>
</section>
