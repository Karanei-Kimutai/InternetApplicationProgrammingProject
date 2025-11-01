<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visit Us - Strathmore University</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-800 flex flex-col min-h-screen">

    <header class="bg-red-600 shadow sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-3 flex justify-between items-center">
            <div>
                <a href="/">
                    <img src="{{ asset('images/strathmore_logo.png') }}" alt="Strathmore University Logo" class="h-10">
                </a>
            </div>
            <div class="flex items-center space-x-6">
                <a href="#" class="text-white hover:text-gray-200 font-medium">Admissions</a>
                <a href="#" class="text-white hover:text-gray-200 font-medium">Academics</a>
                <a href="#" class="text-white hover:text-gray-200 font-medium">Research</a>
                <a href="{{ route('visit.show') }}" class="px-5 py-2 bg-blue-800 hover:bg-blue-900 text-white rounded-md font-medium transition duration-150 ease-in-out">
                    Visit Us
                </a>
            </div>
        </nav>
    </header>

    <main class="container mx-auto max-w-lg mt-12 mb-12 p-8 bg-white rounded-lg shadow-md flex-grow">
        <h1 class="text-2xl font-bold text-center text-gray-700">Guest Pass Application</h1>
        <p class="mt-2 mb-6 text-center text-sm text-gray-600">For visitors who need short-term access.</p>

        <form action="{{ route('visit.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" name="name" id="name" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" id="email" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">ID Photo (Passport, Driver's License, etc.)</label>
                <p class="text-xs text-gray-500 mb-2">Upload a photo or use your camera.</p>
                <input type="file" name="photo" id="photo" accept="image/*" capture="environment"
                       class="w-full text-sm text-gray-500 border border-gray-300 rounded-lg cursor-pointer
                              file:mr-4 file:py-2 file:px-4 file:rounded-l-lg
                              file:border-0 file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100">
            </div>

            <div class="mb-6">
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Visit</label>
                <textarea name="reason" id="reason" rows="4" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <div class="space-y-3">
                <button type="submit"
                        class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-md shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Submit Visitor Information
                </button>
                <a href="{{ route('publicSite.show') }}" class="block w-full text-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-900 font-medium rounded-md border transition">Go Back</a>
                <p class="text-sm text-gray-600 text-center">Are you a university member? <a href="{{ route('universityMemberLogin') }}" class="text-blue-700 hover:underline">Apply as Member</a> instead.</p>
            </div>
        </form>
    </main>

    <footer class="bg-gray-800 text-gray-300 py-12">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; {{ date('Y') }} Strathmore University. All rights reserved.</p>
            <div class="mt-4 space-x-6">
                <a href="#" class="hover:text-white text-sm">Privacy Policy</a>
                <a href="#" class="hover:text-white text-sm">Contact Us</a>
                <a href="#" class="hover:text-white text-sm">Media</a>
            </div>
        </div>
    </footer>

</body>
</html>
