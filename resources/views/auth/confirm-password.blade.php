<x-guest-layout>
    <div class="flex justify-center items-center w-full h-screen bg-gradient-to-r from-green-400 to-blue-500">
        <div class="register-container">
            <div class="register-logo">
                <h2>Confirm Password</h2>
            </div>

            <div class="mb-4 text-sm text-gray-600 text-center">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div class="form-group">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-lock text-teal-600"></i>
                        <x-input-label for="password" :value="__('Password')" />
                    </div>
                    <div class="relative">
                        <input id="password" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-teal-500 focus:ring-teal-500" type="password" name="password" required autocomplete="current-password" />
                        <i id="password-toggle" class="fas fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 cursor-pointer"></i>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div class="form-footer mt-6">
                    <x-primary-button class="btn-submit">
                        {{ __('Confirm') }}
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
