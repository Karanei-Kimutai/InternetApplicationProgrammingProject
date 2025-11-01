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

    <!-- New Navigation Bar - now using justify-end to align content to the right -->
    <nav class="w-full max-w-7xl px-4 py-3 bg-white dark:bg-gray-800 shadow-xl rounded-xl flex justify-end items-center mx-auto mb-10 border border-gray-200 dark:border-gray-700 sticky top-4 z-10">
        
        <!-- Grouping the About Us link and the Dark Mode Toggle on the right -->
        <div class="flex items-center space-x-4">
             <!-- About Us link is now on the right -->
            <a href="/about-us" class="text-gray-600 dark:text-gray-300 hover:text-brand-blue dark:hover:text-blue-400 font-medium transition-colors text-base">About Us</a>

            <!-- Dark Mode Toggle remains on the right -->
            <button onclick="document.documentElement.classList.toggle('dark')" class="p-2 rounded-full text-gray-800 dark:text-white bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 shadow-sm transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            </button>
        </div>
    </nav>


    <!-- Centering wrapper: uses flex-grow to occupy remaining vertical space and centers the main card -->
    <div class="flex flex-grow items-center justify-center w-full">
        <!-- Application Main Container -->
        <main class="flex max-w-lg w-full flex-col items-center p-8 lg:p-12 bg-white dark:bg-dark-bg dark:text-dark-text shadow-xl dark:shadow-[0_4px_20px_rgba(255,250,237,0.1)] rounded-xl border border-gray-200 dark:border-gray-700">

            <!-- Header Content -->
            <div class="text-center mb-10">
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2 tracking-tight">
                    Temporary Pass Application System
                </h1>
                <p class="text-base text-gray-500 dark:text-gray-400">
                    Strathmore University Security Portal
                </p>
            </div>

            <!-- Call-to-Action Buttons -->
            <div class="flex flex-col md:flex-row gap-4 w-full justify-center">

                <!-- Button for University Member -->
                <a
                    href="{{ route('apply.student') }}"
                    class="flex-1 text-center px-6 py-4 border-2 border-brand-blue bg-brand-blue text-white hover:bg-brand-blue/90 hover:border-brand-blue/90 dark:border-blue-400 dark:bg-blue-400 dark:text-gray-900 dark:hover:bg-blue-500 dark:hover:border-blue-500 rounded-lg font-semibold text-lg leading-snug transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-[1.01]"
                >
                    Apply as University Member
                </a>

                <!-- Button for Guest (Styled as secondary) -->
                <a
                    href="{{ route('apply.guest') }}" 
                    class="flex-1 text-center px-6 py-4 border-2 border-brand-green text-brand-green bg-white hover:bg-brand-green/10 dark:border-green-400 dark:text-green-400 dark:bg-dark-bg dark:hover:bg-green-400/10 rounded-lg font-semibold text-lg leading-snug transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-[1.01]"
                >
                    Apply as Guest
                </a>
            </div>

            <!-- Footer/Info Text -->
            <p class="mt-8 text-sm text-gray-400 dark:text-gray-600 text-center">
                Click on the relevant option above to proceed with your pass application.
            </p>
        </main>
    </div>
</body>
</html>
