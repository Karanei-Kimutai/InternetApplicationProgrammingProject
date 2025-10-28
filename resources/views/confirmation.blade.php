<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Received</title>
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
    <meta name="robots" content="noindex">
    <meta name="description" content="Confirmation that your application has been received and is being processed.">
</head>
<body class="min-h-screen bg-gray-100 font-sans antialiased flex items-center justify-center p-6">
    <div class="w-full max-w-2xl bg-white rounded-xl shadow-lg p-10 text-center">
        <div class="mx-auto mb-6 h-16 w-16 rounded-full bg-green-100 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-9 w-9 text-green-600">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-2.59a.75.75 0 1 1 1.06 1.06l-5.25 5.25a.75.75 0 0 1-1.06 0l-2.25-2.25a.75.75 0 1 1 1.06-1.06l1.72 1.72 4.72-4.72Z" clip-rule="evenodd" />
            </svg>
        </div>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Your application has been received</h1>
        <p class="mt-3 text-gray-600">We’re processing it now. You’ll be notified once a decision is made.</p>

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('ams.dashboard') }}" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-5 py-3 text-white font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Go to AMS Dashboard</a>
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center rounded-md bg-gray-100 px-5 py-3 text-gray-900 font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">Back to Home</a>
        </div>
    </div>
</body>
</html>

