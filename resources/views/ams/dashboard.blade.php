<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dummy AMS Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter','sans-serif'] },
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gray-100 font-sans antialiased">
    <!-- Top bar -->
    <header class="bg-white border-b shadow-sm">
        <div class="mx-auto max-w-7xl px-4 py-4 flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-900">University AMS (Dummy)</h1>
            <nav class="text-sm text-gray-600 space-x-4">
                <a href="{{ url('/') }}" class="hover:text-gray-900">Home</a>
                <a href="{{ route('universityMemberLogin') }}" class="hover:text-gray-900">Member Login</a>
            </nav>
        </div>
    </header>

    <!-- Shell -->
    <div class="mx-auto max-w-7xl px-4 py-8 grid grid-cols-12 gap-6">
        <!-- Sidebar -->
        <aside class="col-span-12 md:col-span-3 lg:col-span-3">
            <div class="bg-white rounded-xl shadow p-4">
                <h2 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wider">Navigation</h2>
                <ul class="space-y-2 text-gray-700">
                    <li><a href="#" class="block px-3 py-2 rounded hover:bg-gray-100">Dashboard Home</a></li>
                    <li><a href="#" class="block px-3 py-2 rounded hover:bg-gray-100">Courses</a></li>
                    <li><a href="#" class="block px-3 py-2 rounded hover:bg-gray-100">Profile</a></li>
                    <li><a href="#" class="block px-3 py-2 rounded hover:bg-gray-100">Settings</a></li>
                    <li class="pt-2 border-t"><a href="{{ route('confirmation') }}" class="block px-3 py-2 rounded bg-blue-50 text-blue-700 hover:bg-blue-100">Apply for a temporary pass</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main content -->
        <main class="col-span-12 md:col-span-9 lg:col-span-9">
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900">Welcome to your dashboard</h2>
                <p class="mt-2 text-gray-600">This is a placeholder layout that mimics an AMS dashboard. Replace this area with real widgets, statistics, and shortcuts as your project grows.</p>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="rounded-lg border p-4">
                        <h3 class="font-semibold text-gray-900">Quick Action</h3>
                        <p class="text-gray-600 mt-1">Submit a temporary pass application.</p>
                        <a href="{{ route('confirmation') }}" class="inline-flex mt-3 items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-white text-sm font-medium hover:bg-blue-700">Apply for a temporary pass</a>
                    </div>
                    <div class="rounded-lg border p-4">
                        <h3 class="font-semibold text-gray-900">Announcements</h3>
                        <p class="text-gray-600 mt-1">No announcements yet. This is dummy content.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

