<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ceylon Glow - Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black min-h-screen flex items-center justify-center p-4">
  <div class="bg-black text-white w-full max-w-5xl rounded-lg shadow-lg overflow-hidden">
    
    <!-- Mobile: Logo on top, Desktop: Logo on left -->
    <div class="flex flex-col lg:flex-row">
      <!-- Logo Section -->
      <div class="w-full lg:w-1/2 bg-black flex flex-col items-center justify-center p-6 lg:p-10 text-center">
        <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="w-48 sm:w-64 lg:w-72 mb-4 lg:mb-6">
      </div>

      <!-- Login Form Section -->
      <div class="w-full lg:w-1/2 bg-black p-6 lg:p-10">
      <h2 class="text-2xl font-semibold mb-6">LOGIN</h2>

      <!-- Validation Errors -->
      @if ($errors->any())
        <div class="mb-4">
          <ul class="text-red-500 text-sm list-disc list-inside">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Session Status -->
      @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
          {{ session('status') }}
        </div>
      @endif
      
      <!-- Login Form -->
      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus
               class="w-full px-4 py-3 rounded bg-white text-black focus:outline-none focus:ring-2 focus:ring-[#e5caa1]">

        <input type="password" name="password" placeholder="Password" required
               class="w-full px-4 py-3 rounded bg-white text-black focus:outline-none focus:ring-2 focus:ring-[#e5caa1]">

        <!-- Remember Me -->
        <div class="flex items-center text-sm text-gray-300">
          <input type="checkbox" id="remember_me" name="remember" class="mr-2">
          <label for="remember_me">Remember me</label>
        </div>

        <button type="submit"
                class="w-full bg-[#e5caa1] text-black py-3 rounded font-semibold hover:bg-[#d1b285] transition">
          LOGIN
        </button>
      </form>

      <div class="mt-6 text-center text-sm text-gray-400">
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="underline">Forgot your password?</a>
        @endif
      </div>

      <p class="mt-6 text-center text-sm text-gray-400">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-white underline">Register</a>
      </p>
      </div>
    </div>

  </div>
</body>
</html>
