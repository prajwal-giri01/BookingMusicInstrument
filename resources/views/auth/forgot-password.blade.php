<x-guest-layout>
    <div class="flex justify-center items-center w-full h-screen bg-gradient-to-r from-green-400 to-blue-500">
        <div class="register-container">
            <div class="register-logo">
                <h2>Password Reset</h2>
            </div>

            <div class="mb-4 text-sm text-gray-600 text-center">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-envelope text-teal-600"></i>
                        <x-input-label for="email" :value="__('Email')" />
                    </div>
                    <input id="email" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-teal-500 focus:ring-teal-500" type="email" name="email" value="{{ old('email') }}" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div class="form-footer mt-6">
                    <x-primary-button class="btn-submit">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                    <a class="underline text-sm text-teal-700 hover:text-teal-900 mt-3" href="{{ route('login') }}">
                        {{ __('Back to Login') }}
                    </a>
                </div>
            </form>
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

        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #00796b;
            color: white;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #004d40;
        }
    </style>
</x-guest-layout>
