<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Alpine.js for simple interactivity (like tabs) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

    <!-- 
      Admin Dashboard Layout
      We use Alpine.js (x-data, x-on:click, x-show) to manage which tab is active.
    -->
    <div x-data="{ activeTab: 'university' }" class="min-h-screen">
        
        <!-- Top Navigation Bar -->
        <nav class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo/Title -->
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-xl font-bold text-gray-900">Admin Dashboard</h1>
                    </div>
                    
                    <!-- Logout Link (Placeholder) -->
                    <div class="flex items-center">
                        <!-- 
                            We'll need a proper logout route later.
                            This could be a form that posts to a logout route.
                        -->
                        <a href="{{ route('universityMemberLogin') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                            Log out
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            
            <!-- Tab Navigation (from your sketch) -->
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <!-- University Member applications Tab -->
                    <button
                        @click="activeTab = 'university'"
                        :class="{
                            'border-blue-500 text-blue-600': activeTab === 'university',
                            'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'university'
                        }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors"
                    >
                        University Member applications
                    </button>

                    <!-- Guest applications Tab -->
                    <button
                        @click="activeTab = 'guest'"
                        :class="{
                            'border-blue-500 text-blue-600': activeTab === 'guest',
                            'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'guest'
                        }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors"
                    >
                        Guest applications
                    </button>

                    <!-- Statistics Tab -->
                    <button
                        @click="activeTab = 'statistics'"
                        :class="{
                            'border-blue-500 text-blue-600': activeTab === 'statistics',
                            'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'statistics'
                        }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors"
                    >
                        Statistics
                    </button>
                </nav>
            </div>

            <!-- Tab Content (The large empty area from your sketch) -->
            <div class="mt-6">
                <!-- University Member applications Content -->
                <div x-show="activeTab === 'university'" class="p-6 bg-white rounded-lg shadow">
                    <h2 class="text-lg font-medium text-gray-900">University Member Applications</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        This area will display a table or list of university member applications.
                    </p>
                    <!-- TODO: Add application table here -->
                </div>

                <!-- Guest applications Content -->
                <div x-show="activeTab === 'guest'" class="p-6 bg-white rounded-lg shadow">
                    <h2 class="text-lg font-medium text-gray-900">Guest Applications</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        This area will display a table or list of guest applications.
                    </to>
                    <!-- TODO: Add application table here -->
                </div>

                <!-- Statistics Content -->
                <div x-show="activeTab === 'statistics'" class="p-6 bg-white rounded-lg shadow">
                    <h2 class="text-lg font-medium text-gray-900">Statistics</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        This area will display various charts and statistics.
                    </p>
                    <!-- TODO: Add charts here -->
                </div>
            </div>

        </main>
    </div>

</body>
</html>
