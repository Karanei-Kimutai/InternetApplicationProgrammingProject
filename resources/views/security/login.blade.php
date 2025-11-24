<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Portal Login</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/tp-logo.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="robots" content="noindex">
</head>
<body class="min-h-screen bg-slate-900 flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white/95 backdrop-blur rounded-2xl shadow-2xl p-8 space-y-6">
        <div class="text-center space-y-2">
            <div class="flex justify-center">
                <img src="{{ asset('images/tp-logo.svg') }}" alt="Temporary Pass logo" class="h-14 w-auto">
            </div>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Security Portal</p>
            <h1 class="text-2xl font-bold text-slate-900">Sign in to verify passes</h1>
        </div>

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('security.login.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="text-sm font-medium text-slate-700">Email</label>
                <input type="email" id="email" name="email" required autofocus value="{{ old('email') }}"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50">
            </div>
            <div>
                <label for="password" class="text-sm font-medium text-slate-700">Password</label>
                <input type="password" id="password" name="password" required
                       class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50">
            </div>
            <button type="submit"
                    class="w-full rounded-xl bg-blue-600 px-4 py-3 text-white font-semibold shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Sign In
            </button>
        </form>
        <p class="text-center text-xs text-slate-400">If you have trouble signing in, contact the AMS administrator.</p>
    </div>
</body>
</html>
