<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aida Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body class="flex flex-col lg:flex-row min-h-screen font-sans overflow-y-auto">

    <!-- ✅ IMAGE MOBILE (visible seulement sur petits écrans) -->
    <div class="block lg:hidden w-full bg-cover bg-center relative h-[280px]"
         style="background-image: url('{{ asset('images/loginaida.png') }}');">
        <div class="absolute inset-0 bg-black opacity-40"></div>
        <div class="relative z-10 text-white text-center px-6 py-10">
            <img src="{{ asset('images/logologin.png') }}" alt="Aida Logo" class="mx-auto w-32 mb-4">
            <h1 class="text-2xl font-bold">Welcome to Aida</h1>
            <p class="text-sm">Smart energy optimization</p>
        </div>
    </div>

    <!-- ✅ IMAGE DESKTOP (à gauche, cachée sur mobile) -->
    <div class="w-1/2 hidden lg:flex items-center justify-center bg-cover bg-center relative"
         style="background-image: url('{{ asset('images/loginaida.png') }}');">
        <div class="absolute inset-0 bg-black opacity-40"></div>
        <div class="relative z-10 text-white text-center px-10">
            <img src="{{ asset('images/logologin.png') }}" alt="Aida Logo" class="mx-auto w-[360px] mb-12">
            <h1 class="text-5xl font-extrabold mb-6 leading-tight">Welcome to Aida</h1>
            <p class="text-xl font-medium leading-relaxed">
                The first AI Agent Designed solely to optimize<br> energy usage
            </p>
        </div>
    </div>

    <!-- ✅ FORMULAIRE -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto max-h-screen">
        <div class="w-full max-w-md space-y-6">
            <h2 class="text-3xl font-bold text-gray-900">Log in</h2>

            <p class="text-sm">
                New user?
                <a href="{{ route('register') }}" class="text-green-600 hover:underline">Create an account</a>
            </p>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" name="email" type="email" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <div class="text-right">
                    <a href="{{ route('password.request') }}" class="text-gray-500 text-sm hover:underline">
                        Forgot password?
                    </a>
                </div>

                <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    Log in
                </button>
            </form>

            <!-- OR separator -->
            <div class="flex items-center justify-center gap-4">
                <hr class="w-1/3 border-gray-300"> <span class="text-gray-400 text-sm">or</span> <hr class="w-1/3 border-gray-300">
            </div>

            <!-- Social login -->
            <div class="space-y-3">
                <button class="w-full flex items-center justify-center gap-2 border border-gray-300 py-2 rounded-md hover:bg-gray-50 text-sm font-medium">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                    Log in with Google
                </button>

                <button class="w-full flex items-center justify-center gap-2 border border-gray-300 py-2 rounded-md hover:bg-gray-50 text-sm font-medium">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/Facebook_Logo_%282019%29.png" class="w-5 h-5" alt="Facebook">
                    Log in with Facebook
                </button>
            </div>

            <p class="text-[13px] text-gray-400 text-center leading-snug">
                Protected by reCAPTCHA and subject to the Google
                <a href="#" class="text-blue-500 hover:underline">Privacy Policy</a> and
                <a href="#" class="text-blue-500 hover:underline">Terms of Service</a>.
            </p>
        </div>
    </div>

</body>
</html>
