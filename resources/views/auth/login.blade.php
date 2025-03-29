<x-guest-layout>
    <!-- Outer Div for Form Container -->
    <div class="flex justify-center items-center w-full h-screen bg-gradient-to-r from-green-400 to-blue-500">
        <div class="login-container">
            <!-- Logo or Title -->
            <div class="login-logo">
                <h2>Login</h2>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-envelope text-teal-600"></i>
                        <x-input-label for="email" :value="__('Email')" />
                    </div>
                    <div class="relative">
                        <input id="email" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-teal-500 focus:ring-teal-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="form-group mt-4">
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

                <!-- Remember Me -->
                <div class="form-group mt-4 flex items-center gap-2">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-teal-600 focus:ring-teal-500" name="remember">
                    <label for="remember_me" class="text-sm text-gray-600">{{ __('Remember me') }}</label>
                </div>

                <!-- Forgot Password and Submit Button -->
                <div class="form-footer mt-6">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-teal-700 hover:text-teal-900" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                    <x-primary-button class="btn-submit">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
                <div class="mt-4 text-center">
                    <span class="text-sm text-gray-600">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="text-sm text-teal-600 hover:underline">Register</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 50px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: scale(1.02);
        }

        .login-logo h2 {
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

    <!-- JavaScript for Password Visibility Toggle -->
    <script>
        document.getElementById('password-toggle').addEventListener('click', function() {
            var passwordInput = document.getElementById('password');
            var passwordToggleIcon = document.getElementById('password-toggle');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggleIcon.classList.remove('fa-eye');
                passwordToggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordToggleIcon.classList.remove('fa-eye-slash');
                passwordToggleIcon.classList.add('fa-eye');
            }
        });
    </script>
</x-guest-layout>
