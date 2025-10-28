<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Member Login</title>
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
<body class="bg-gray-100 font-sans antialiased">

    <!-- Main container centered on the page -->
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            
            <!-- Login Card -->
            <div class="bg-white max-w-md w-full p-8 sm:p-10 rounded-xl shadow-lg">
                
                <!-- Header -->
                <div>
                    <!-- You could put a university logo here -->
                    <!-- <img class="mx-auto h-12 w-auto" src="https://placehold.co/200x100?text=University+Logo" alt="University Logo"> -->
                    <h2 class="mt-6 text-center text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">
                        Sign in with your AMS Credentials
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        University Member Portal
                    </p>
                </div>
                
                <!-- 
                    Login Form
                    Action points to the named submission route.
                -->
                <form class="mt-8 space-y-6" action="{{ route('universityMemberLogin.submit') }}" method="POST">
                    <!-- CSRF Token (Essential for Laravel forms) -->
                    @csrf

                    <div class="rounded-md shadow-sm -space-y-px">
                        <!-- Username Field -->
                        <div>
                            <label for="username" class="sr-only">Username</label>
                            <input id="username" name="username" type="text" autocomplete="username" required
                                class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                                placeholder="Username">
                        </div>
                        
                        <!-- Password Field -->
                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                                placeholder="Password">
                        </div>
                    </div>

                    <!-- Options (e.g., Forgot Password) -->
                    <div class="flex items-center justify-between">
                        <div class="text-sm">
                            <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                                Forgot your password?
                            </a>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Sign in
                        </button>
                    </div>
                </form>
                
                <!-- Link to Admin Login -->
                <div class="mt-6 text-center text-sm">
                    <!-- 
                        Laravel Tip: Link to the admin login route
                    -->
                    <a href="{{ route('adminLogin') }}" class="font-medium text-gray-600 hover:text-gray-900">
                        Are you an administrator?
                    </a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>

