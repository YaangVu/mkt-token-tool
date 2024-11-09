<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body
    class="min-h-screen bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 flex items-center justify-center p-4">
<main class="w-full max-w-2xl bg-white/10 rounded-2xl shadow-2xl p-8 space-y-8 transition-transform">
    <div class="text-center">
        <h1 class="text-3xl font-bold text-white mb-2">Crypto Registration</h1>
        <p class="text-gray-200">Join the future of digital finance</p>
    </div>

    <form class="space-y-6" id="registrationForm" action="{{ route('clientSignUp') }}" method="POST">
        @csrf
        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label for="username" class="block text-gray-200 font-medium">Username</label>
                <input type="text" id="username" name="username" required
                       class="w-full px-4 py-3 bg-white/5 border border-gray-300/20 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none text-white transition-all"
                       aria-describedby="usernameError">
                @if ($errors->has('username'))
                    <p id="usernameError" class="text-red-400 text-sm">{{ $errors->first('username') }}</p>
                @endif
            </div>

            <div class="space-y-2">
                <label for="deposit" class="block text-gray-200 font-medium">Initial Deposit (USD)</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">$</span>
                    <input type="number" id="deposit" name="deposit" min="0" step="0.01" required
                           class="[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none w-full pl-8 pr-4 py-3 bg-white/5 border border-gray-300/20 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none text-white transition-all"
                           aria-describedby="depositError">
                </div>
                @if ($errors->has('deposit'))
                    <p id="depositError" class="text-red-400 text-sm">{{ $errors->first('deposit') }}</p>
                @endif
            </div>

            <div class="space-y-2">
                <label for="password" class="block text-gray-200 font-medium">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-3 bg-white/5 border border-gray-300/20 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none text-white transition-all"
                           aria-describedby="passwordError">
                    <button type="button" onclick="togglePassword('password')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <p id="passwordError" class="text-red-400 text-sm hidden">Password must be at least 8 characters</p>
            </div>

            <div class="space-y-2">
                <label for="confirmPassword" class="block text-gray-200 font-medium">Confirm Password</label>
                <div class="relative">
                    <input type="password" id="confirmPassword" name="password_confirmation" required
                           class="w-full px-4 py-3 bg-white/5 border border-gray-300/20 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none text-white transition-all"
                           aria-describedby="confirmPasswordError">
                    <button type="button" onclick="togglePassword('confirmPassword')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <p id="confirmPasswordError" class="text-red-400 text-sm hidden">Passwords do not match</p>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="p-4 bg-white/85 rounded-lg w-48 h-48 flex items-center justify-center">
                <img src="{{ asset('storage/bank-account.png') }}" alt="QR Code" class="w-full h-full object-contain">
            </div>
        </div>

        <button type="submit"
                class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-4 px-8 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all focus:ring-4 focus:ring-purple-500 focus:ring-opacity-50">
            Register Now
        </button>
    </form>

    <div class="flex justify-center mt-4">
        <a href="{{ route('filament.admin.tenant') }}"
           class="w-full bg-gradient-to-r from-yellow-400 to-yellow-600 text-white font-bold py-4 px-8 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all focus:ring-4 focus:ring-yellow-500 focus:ring-opacity-50 text-center">
            Sign In
        </a>
    </div>
</main>

<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        input.type = input.type === "password" ? "text" : "password";
    }

    document.getElementById("registrationForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;
        const passwordError = document.getElementById("passwordError");
        const confirmPasswordError = document.getElementById("confirmPasswordError");

        // Reset error messages
        passwordError.classList.add("hidden");
        confirmPasswordError.classList.add("hidden");

        // Validate password length
        if (password.length < 8) {
            passwordError.classList.remove("hidden");
            return false;
        }

        // Validate password match
        if (password !== confirmPassword) {
            confirmPasswordError.classList.remove("hidden");
            return false;
        }

        // If validation passes, submit the form
        this.submit();
    });
</script>
</body>
</html>
