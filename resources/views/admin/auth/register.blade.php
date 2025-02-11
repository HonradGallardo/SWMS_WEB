<x-guest-layout>
    <form method="POST" action="{{ route('admin.register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10"
                              type="password"
                              name="password"
                              maxlength="30"
                              required autocomplete="new-password" />
                <button type="button" onclick="togglePassword('password', 'togglePasswordIcon1')"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-600">
                    <span id="togglePasswordIcon1">😐</span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10"
                              type="password"
                              name="password_confirmation"
                              maxlength="30"
                              required autocomplete="new-password" />
                <button type="button" onclick="togglePassword('password_confirmation', 'togglePasswordIcon2')"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-600">
                    <span id="togglePasswordIcon2">😐</span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('admin.login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.textContent = "😑"; // Hide icon
            } else {
                input.type = "password";
                icon.textContent = "😐"; // Show icon
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector("form");
            const emailInput = document.getElementById("email");
            const passwordInput = document.getElementById("password");
            const confirmPasswordInput = document.getElementById("password_confirmation");

            form.addEventListener("submit", function (event) {
                const email = emailInput.value.trim();
                const password = passwordInput.value.trim();
                const confirmPassword = confirmPasswordInput.value.trim();

                // Email validation
                if (email.length > 30) {
                    alert("Email must not exceed 30 characters.");
                    event.preventDefault();
                    return;
                }

                // Password validation
                if (password.length < 8 || password.length > 30) {
                    alert("Password must be between 8 and 30 characters.");
                    event.preventDefault();
                    return;
                }

                const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,30}$/;
                const commonPasswords = ["12345678", "password", "qwerty", "123456789", "abc123", "admin123", "letmein"];

                if (!passwordRegex.test(password)) {
                    alert("Password must include at least 1 uppercase letter, 1 number, and 1 special character.");
                    event.preventDefault();
                    return;
                }

                if (commonPasswords.includes(password.toLowerCase())) {
                    alert("Please choose a stronger password.");
                    event.preventDefault();
                    return;
                }

                // Confirm password validation
                if (password !== confirmPassword) {
                    alert("Passwords do not match.");
                    event.preventDefault();
                }
            });
        });
    </script>
</x-guest-layout>
