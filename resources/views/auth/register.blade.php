<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Aida</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body class="flex flex-col lg:flex-row min-h-screen font-sans overflow-y-auto">

    <!-- ✅ IMAGE MOBILE -->
    <div class="block lg:hidden w-full bg-cover bg-center relative h-[280px]"
         style="background-image: url('{{ asset('images/loginaida.png') }}');">
        <div class="absolute inset-0 bg-black opacity-40"></div>
        <div class="relative z-10 text-white text-center px-6 py-10">
            <img src="{{ asset('images/logologin.png') }}" alt="Aida Logo" class="mx-auto w-32 mb-4">
            <h1 class="text-2xl font-bold">Join Aida</h1>
            <p class="text-sm">Smart energy optimization starts here</p>
        </div>
    </div>

    <!-- ✅ IMAGE DESKTOP -->
    <div class="w-1/2 hidden lg:flex items-center justify-center bg-cover bg-center relative"
         style="background-image: url('{{ asset('images/loginaida.png') }}');">
        <div class="absolute inset-0 bg-black opacity-40"></div>
        <div class="relative z-10 text-white text-center px-10">
            <img src="{{ asset('images/logologin.png') }}" alt="Aida Logo" class="mx-auto w-[360px] mb-10">
            <h1 class="text-5xl font-extrabold mb-6 leading-tight">Join Aida</h1>
            <p class="text-xl font-medium leading-relaxed">
                Start optimizing your energy usage with<br> our AI-powered platform.
            </p>
        </div>
    </div>

    <!-- ✅ FORMULAIRE -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto max-h-screen">
        <div class="w-full max-w-md space-y-6">
            <h2 class="text-3xl font-bold text-gray-900">Create an account</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input id="name" name="name" type="text" required autofocus
                           class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    Sign Up
                </button>
            </form>

            <div class="text-center text-sm">
                Already have an account?
                <a href="{{ route('login') }}" class="text-green-600 hover:underline">Log in</a>
            </div>
        </div>
    </div>

</body>
</html>
