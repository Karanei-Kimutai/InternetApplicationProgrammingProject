<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strathmore Temporary Pass Application</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s;
        }
    </style>
    <script>
        // Tailwind Custom Configuration (Optional, but helps with consistency)
        tailwind.config = {
            darkMode: 'class', // Enables dark mode based on 'dark' class
            theme: {
                extend: {
                    colors: {
                        'brand-blue': '#1D4ED8', // Primary blue for University member
                        'brand-green': '#059669', // Primary green for Guest
                        'dark-bg': '#161615',
                        'dark-text': '#EDEDEC',
                    },
                    borderRadius: {
                        'lg': '0.75rem',
                    }
                }
            }
        }
    </script>
</head>
<!-- Updated body classes to enable vertical flex layout -->
<body class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col p-4">

    <!-- Top Navigation -->
    <nav class="w-full max-w-7xl px-4 py-3 bg-white dark:bg-gray-800 shadow-xl rounded-xl flex items-center mx-auto mb-10 border border-gray-200 dark:border-gray-700 sticky top-4 z-10">
        <!-- Brand -->
        <a href="{{ route('publicSite.show') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/strathmore_logo.png') }}" alt="Strathmore Logo" class="h-8 w-auto object-contain" />
            <span class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Strathmore University</span>
        </a>
        <!-- Nav links -->
        <div class="ms-auto flex items-center gap-4">
            <a href="{{ route('publicSite.show') }}" class="text-gray-700 dark:text-gray-300 hover:text-brand-blue dark:hover:text-blue-400 font-medium">Home</a>
            <a href="{{ route('visit.show') }}" class="text-gray-700 dark:text-gray-300 hover:text-brand-blue dark:hover:text-blue-400 font-medium">Visit Us</a>
            <a href="{{ route('universityMemberLogin') }}" class="text-gray-700 dark:text-gray-300 hover:text-brand-blue dark:hover:text-blue-400 font-medium">Student Login</a>
            <button title="Toggle theme" onclick="document.documentElement.classList.toggle('dark')" class="p-2 rounded-full text-gray-800 dark:text-white bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 shadow-sm transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            </button>
        </div>
    </nav>


    <!-- Centering wrapper: uses flex-grow to occupy remaining vertical space and centers the main card -->
    <div class="flex flex-grow items-center justify-center w-full">
        <!-- Application Main Container -->
        <main class="flex max-w-4xl w-full flex-col items-center p-0 bg-transparent">
            <!-- Hero -->
            <section class="w-full overflow-hidden rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 bg-gradient-to-br from-[#0a3a8c] to-[#123f9c] text-white">
                <div class="px-8 py-10 md:px-12 md:py-14">
                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Temporary Pass Application System</h1>
                    <p class="mt-3 text-white/90 max-w-2xl">Access control for visitors and university members. Choose your path below to begin your application.</p>
                    <div class="mt-6 flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('apply.student') }}" class="inline-flex items-center justify-center rounded-lg px-6 py-3 font-semibold bg-white text-[#0a3a8c] hover:bg-white/90 shadow">
                            Apply as University Member
                        </a>
                        <a href="{{ route('apply.guest') }}" class="inline-flex items-center justify-center rounded-lg px-6 py-3 font-semibold border border-white/40 hover:bg-white/10">
                            Apply as Guest
                        </a>
                    </div>
                </div>
            </section>

            <!-- Features -->
            <section class="w-full mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-dark-bg rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Secure</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Authentication against the University AMS to keep your data safe.</p>
                </div>
                <div class="bg-white dark:bg-dark-bg rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Fast</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Simple forms for members and guests to get you through quickly.</p>
                </div>
                <div class="bg-white dark:bg-dark-bg rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Support</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Need help? Visit the public site or contact systems@strathmore.edu.</p>
                </div>
            </section>

            <p class="mt-8 text-sm text-gray-500 dark:text-gray-400 text-center">Choose an option above to start your application.</p>
        </main>
    </div>
</body>
</html>
