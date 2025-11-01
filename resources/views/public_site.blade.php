<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Strathmore University</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* This is a placeholder style. */
        /* You MUST add a real image to 'public/images/strathmore_campus_placeholder.jpg' for this to work */
        .hero-bg {
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('/images/strathmore_campus_placeholder.png');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-800">

    <header class="bg-red-600 shadow sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-3 flex justify-between items-center">
            <div>
                <a href="/">
                    <img src="/images/strathmore_logo_placeholder.png" alt="Strathmore University Logo" class="h-10">
                </a>
            </div>
            <div class="flex items-center space-x-6">
                <a href="#" class="text-white hover:text-gray-200 font-medium">Admissions</a>
                <a href="#" class="text-white hover:text-gray-200 font-medium">Academics</a>
                <a href="#" class="text-white hover:text-gray-200 font-medium">Research</a>
                <a href="{{ route('visit.show') }}" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition duration-150 ease-in-out">
                    Visit Us
                </a>
            </div>
        </nav>
    </header>

    <section class="hero-bg h-96 flex items-center justify-center text-white">
        <div class="text-center z-10 p-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Excellence. Innovation. Service.</h1>
            <p class="text-lg md:text-xl mb-6">Discover your potential at Strathmore University.</p>
            <a href="#" class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-gray-900 rounded-md font-semibold transition duration-150 ease-in-out">Apply Now</a>
        </div>
    </section>

    <main class="container mx-auto mt-16 px-6">
        <h2 class="text-3xl font-bold text-center mb-10 text-gray-700">Explore Strathmore</h2>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                <div class="h-48 w-full bg-gray-300 flex items-center justify-center text-gray-500 font-semibold">[Image: Academic Programs]</div>
                <div class="p-6 flex-grow">
                    <h3 class="text-xl font-semibold mb-2">Academic Programs</h3>
                    <p class="text-gray-600 mb-4">Find undergraduate and postgraduate programs designed for impact.</p>
                </div>
                <div class="p-6 pt-0">
                    <a href="#" class="text-blue-600 hover:underline font-medium">Learn More &rarr;</a>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                <div class="h-48 w-full bg-gray-300 flex items-center justify-center text-gray-500 font-semibold">[Image: Campus Life]</div>
                <div class="p-6 flex-grow">
                    <h3 class="text-xl font-semibold mb-2">Campus Life</h3>
                    <p class="text-gray-600 mb-4">Experience a vibrant community with diverse clubs and activities.</p>
                </div>
                 <div class="p-6 pt-0">
                    <a href="#" class="text-blue-600 hover:underline font-medium">Discover Activities &rarr;</a>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                <div class="h-48 w-full bg-gray-300 flex items-center justify-center text-gray-500 font-semibold">[Image: Research & Innovation]</div>
                <div class="p-6 flex-grow">
                    <h3 class="text-xl font-semibold mb-2">Research & Innovation</h3>
                    <p class="text-gray-600 mb-4">Engage with cutting-edge research and innovation hubs.</p>
                </div>
                 <div class="p-6 pt-0">
                    <a href="#" class="text-blue-600 hover:underline font-medium">Explore Research &rarr;</a>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-gray-300 mt-20 py-12">
    <div class="container mx-auto px-6 text-center">
        <p>&copy; {{ date('Y') }} Strathmore University. All rights reserved.</p>
        <div class="mt-4 space-x-6">
            <a href="#" class="hover:text-white text-sm">Privacy Policy</a>
            <a href="#" class="hover:text-white text-sm">Contact Us</a>
            <a href="#" class="hover:text-white text-sm">Media</a>
            <a href="{{ route('ams.dashboard') }}" class="hover:text-white text-sm">AMS students' module</a>
            <a href="{{ route('universityMemberLogin') }}" class="hover:text-white text-sm">University Member Login</a>
        </div>
    </div>
</footer>

</body>
</html>