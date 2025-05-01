@extends('frontend.Master')
@section('content')
    <style>
        /* Enhanced Profile Page Styling */
        .profile-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 50px 20px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .profile-title {
            font-size: 32px;
            font-weight: 700;
            color: #1A1A2E;
            margin-bottom: 10px;
        }

        .profile-subtitle {
            font-size: 16px;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .profile-section {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .profile-card {
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            padding: 30px;
            background: linear-gradient(135deg, #1A1A2E 0%, #2A2A46 100%);
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }

        .card-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .card-header p {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.7);
            position: relative;
            z-index: 1;
        }

        .card-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            color: #333;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #C7B299;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(199, 178, 153, 0.15);
            outline: none;
        }

        .form-error {
            color: #e53e3e;
            font-size: 13px;
            margin-top: 6px;
        }

        .verification-notice {
            background-color: #fff8e6;
            border-left: 4px solid #f6ad55;
            padding: 12px 15px;
            margin: 15px 0;
            border-radius: 6px;
            font-size: 14px;
            color: #805a1e;
        }

        .verification-sent {
            background-color: #f0fff4;
            border-left: 4px solid #68d391;
            padding: 12px 15px;
            margin: 15px 0;
            border-radius: 6px;
            font-size: 14px;
            color: #2f855a;
        }

        .verification-link {
            background: none;
            border: none;
            color: #805a1e;
            text-decoration: underline;
            cursor: pointer;
            font-size: 14px;
            padding: 0;
            margin: 0;
        }

        .verification-link:hover {
            color: #9c6f27;
        }

        .btn-submit {
            display: inline-block;
            background: linear-gradient(135deg, #C7B299 0%, #E6CCB2 100%);
            color: #1A1A2E;
            font-weight: 700;
            font-size: 15px;
            padding: 14px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(199, 178, 153, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(199, 178, 153, 0.4);
        }

        .btn-submit:active {
            transform: translateY(1px);
        }

        .success-message {
            display: inline-block;
            background-color: #f0fff4;
            color: #2f855a;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 6px;
            margin-left: 15px;
            animation: fadeOut 2s forwards;
            animation-delay: 2s;
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }

        .password-requirements {
            margin-top: 15px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 10px;
        }

        .password-requirements h4 {
            font-size: 14px;
            font-weight: 600;
            color: #444;
            margin-bottom: 10px;
        }

        .password-requirements ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .password-requirements li {
            font-size: 13px;
            color: #666;
            margin-bottom: 5px;
            padding-left: 20px;
            position: relative;
        }

        .password-requirements li::before {
            content: '•';
            position: absolute;
            left: 0;
            color: #C7B299;
        }

        @media screen and (min-width: 768px) {
            .profile-section {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media screen and (max-width: 768px) {
            .profile-container {
                padding: 30px 15px;
            }

            .profile-title {
                font-size: 28px;
            }

            .card-header {
                padding: 25px;
            }

            .card-body {
                padding: 25px;
            }

            .btn-submit {
                width: 100%;
            }

            .success-message {
                display: block;
                margin: 15px 0 0 0;
                text-align: center;
            }
        }
    </style>

    <div class="profile-container" style="margin-top: 2rem;">
        <div class="profile-header">
            <h1 class="profile-title">Your Profile</h1>
            <p class="profile-subtitle">Manage your account information and change your password</p>
        </div>

        <div class="profile-section">
            <!-- Profile Information Section -->
            <div class="profile-card">
                <div class="card-header">
                    <h2>Personal Information</h2>
                    <p>Update your name and email address</p>
                </div>
                <div class="card-body">
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="form-group">
                            <label for="name" class="form-label">Full Name</label>
                            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                            @error('name') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                            @error('email') <p class="form-error">{{ $message }}</p> @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="verification-notice">
                                    {{ __('Your email address is unverified.') }}
                                    <button form="send-verification" class="verification-link">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </div>

                                @if (session('status') === 'verification-link-sent')
                                    <div class="verification-sent">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </div>
                                @endif
                            @endif
                        </div>

                        <div>
                            <button type="submit" class="btn-submit">{{ __('Update Profile') }}</button>

                            @if (session('status') === 'profile-updated')
                                <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="success-message">
                                    {{ __('Saved successfully!') }}
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password Section -->
            <div class="profile-card">
                <div class="card-header">
                    <h2>Security</h2>
                    <p>Update your password to keep your account secure</p>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" required />
                            @error('current_password') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">New Password</label>
                            <input id="password" name="password" type="password" class="form-control" autocomplete="new-password" required />
                            @error('password') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" required />
                            @error('password_confirmation') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn-submit">{{ __('Change Password') }}</button>

                            @if (session('status') === 'password-updated')
                                <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="success-message">
                                    {{ __('Password updated!') }}
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
