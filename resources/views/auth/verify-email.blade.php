<x-guest-layout>
    <div class="flex justify-center items-center w-full h-screen bg-gradient-to-r from-green-400 to-blue-500">
        <div class="register-container">
            <div class="register-logo">
                <h2>Email Verification</h2>
            </div>

            <div class="mb-4 text-sm text-gray-600 text-center">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600 text-center">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-6 flex items-center justify-between">
                <!-- Resend Verification Email -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-primary-button class="btn-submit w-full mb-3">
                        {{ __('Resend Verification Email') }}
                    </x-primary-button>
                </form>

                <!-- Log Out Button -->
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="btn-secondary w-full">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .register-container {
            width: 100%;
            max-width: 400px;
            padding: 50px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .register-container:hover {
            transform: scale(1.02);
        }

        .register-logo h2 {
            text-align: center;
            font-size: 36px;
            font-weight: bold;
            color: #00796b;
            margin-bottom: 20px;
        }

        .btn-submit, .btn-secondary {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            color: white;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .btn-submit {
            background-color: #00796b;
        }

        .btn-submit:hover {
            background-color: #004d40;
        }

        .btn-secondary {
            background-color: #FF6B6B;
        }

        .btn-secondary:hover {
            background-color: #E53935;
        }
    </style>
</x-guest-layout>
