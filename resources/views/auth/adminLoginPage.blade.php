<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Configure Tailwind to use Inter font -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-gray-900 font-sans antialiased"> <!-- Darker background for admin -->

    <!-- Main container centered on the page -->
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            
            <!-- Login Card -->
            <div class="bg-white max-w-md w-full p-8 sm:p-10 rounded-xl shadow-lg">
                
                <!-- Header -->
                <div>
                    <!-- Admin-specific icon or logo -->
                    <!-- <img class="mx-auto h-12 w-auto" src="https://placehold.co/100x100/ef4444/ffffff?text=ADMIN" alt="Admin Lock"> -->
                    <h2 class="mt-6 text-center text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">
                        Admin Login
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Authorized Personnel Only
                    </p>
                </div>
                
                <!-- 
                    Login Form
                    Action points to the named submission route.
                -->
                <form class="mt-8 space-y-6" action="{{ route('adminLogin.submit') }}" method="POST">
                    <!-- CSRF Token (Essential for Laravel forms) -->
                    @csrf

                    <div class="rounded-md shadow-sm -space-y-px">
                        <!-- Username Field -->
                        <div>
                            <label for="username" class="sr-only">Username</label>
                            <input id="username" name="username" type="text" autocomplete="username" required
                                class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-red-500 focus:border-red-500 focus:z-10 sm:text-sm"
                                placeholder="Admin Username">
                        </div>
                        
                        <!-- 
                            HERE IS THE PASSWORD FIELD 
                            (I fixed a typo in the closing label tag)
                        -->
                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-red-500 focus:border-red-500 focus:z-10 sm:text-sm"
                                placeholder="Password">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                            Login
                        </button>
                    </div>
                </form>

                <!-- Link back to Member Login -->
                <div class="mt-6 text-center text-sm">
                    <!-- 
                        Laravel Tip: Link to the member login route
                    -->
                    <a href="{{ route('universityMemberLogin') }}" class="font-medium text-gray-600 hover:text-gray-900">
                        Return to Member login
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

