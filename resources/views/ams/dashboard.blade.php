<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dummy AMS Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter','system-ui','sans-serif'] },
                    colors: {
                        // Strathmore‑like palette (approx.)
                        sublue: {
                            50: '#e7eef8',
                            600: '#0a3a8c', // primary deep blue
                            700: '#082f74'
                        },
                        sured: {
                            50: '#fde8ea',
                            500: '#b32428', // brand red seen in chat widget
                            600: '#9e1f23'
                        }
                    },
                    borderRadius: { pill: '9999px' }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gray-50 font-sans antialiased">
    <!-- Info bar -->
    <div class="bg-sublue-600 text-white" style="background-color:#0a3a8c">
        <div class="mx-auto max-w-7xl px-4 py-2 text-xs sm:text-sm flex flex-wrap items-center gap-x-6 gap-y-2">
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M2 4.5A2.5 2.5 0 0 1 4.5 2h1.764a2.5 2.5 0 0 1 2.43 1.86l.42 1.683a2.5 2.5 0 0 1-.801 2.5l-1.09.908a14.5 14.5 0 0 0 6.057 6.057l.908-1.09a2.5 2.5 0 0 1 2.5-.801l1.682.42A2.5 2.5 0 0 1 22 17.736V19.5A2.5 2.5 0 0 1 19.5 22h-1A16.5 16.5 0 0 1 2 5.5v-1Z"/></svg>
                <span>Call us: (+254) 0703‑034000 / 0703‑034200</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M1.5 6.75A2.25 2.25 0 0 1 3.75 4.5h16.5a2.25 2.25 0 0 1 2.25 2.25v10.5A2.25 2.25 0 0 1 20.25 19.5H3.75A2.25 2.25 0 0 1 1.5 17.25V6.75Zm2.4-.75a.75.75 0 0 0-.45 1.364l7.2 5.143a1.5 1.5 0 0 0 1.7 0l7.2-5.143A.75.75 0 0 0 19.85 6H3.9Z"/></svg>
                <span>Email: systems@strathmore.edu</span>
        </div>
    </div>
    </div>

    <!-- Brand header / nav -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b">
        <div class="mx-auto max-w-7xl px-4 py-4 flex items-center gap-4">
            <div class="flex items-center gap-3">
                <img src="https://placehold.co/36x36" alt="University Logo" class="h-9 w-9 rounded" />
                <span class="text-lg font-semibold text-gray-900">suLMS (Dummy)</span>
            </div>
            <nav class="ms-auto hidden md:flex items-center gap-6 text-sm">
                <a href="#" class="text-gray-700 hover:text-gray-900">Home</a>
                <a href="#" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                <a href="#" class="text-gray-700 hover:text-gray-900">My courses</a>
                <a href="#" class="text-gray-700 hover:text-gray-900">Additional Resources</a>
                <a href="#" class="text-gray-700 hover:text-gray-900">University Library</a>
                <a href="#" class="text-gray-700 hover:text-gray-900">Help</a>
                <a href="{{ route('universityMemberLogin') }}" class="inline-flex items-center rounded-md px-3 py-1.5 text-white hover:opacity-90" style="background-color:#0a3a8c">Sign in</a>
            </nav>
        </div>
    </header>

    <!-- Layout -->
    <div class="mx-auto max-w-7xl px-4 py-6 grid grid-cols-12 gap-6">
        <!-- Search courses (dummy to mimic LMS) -->
        <div class="col-span-12">
            <div class="bg-white rounded-xl border shadow-sm p-4">
                <form action="#" method="get" class="flex items-stretch gap-2">
                    <label for="course-search" class="sr-only">Search courses</label>
                    <input id="course-search" type="text" placeholder="Search courses" class="flex-1 rounded-md border-gray-300 focus:border-sublue-600 focus:ring-sublue-600" />
                    <button type="submit" class="inline-flex items-center justify-center rounded-md px-4 py-2 text-white" style="background-color:#0a3a8c">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 3.929 12.24l3.79 3.79a.75.75 0 1 0 1.06-1.06l-3.79-3.79A6.75 6.75 0 0 0 10.5 3.75Zm-5.25 6.75a5.25 5.25 0 1 1 10.5 0 5.25 5.25 0 0 1-10.5 0Z" clip-rule="evenodd"/></svg>
                    </button>
                </form>
            </div>
        </div>
        <!-- Sidebar -->
        <aside class="col-span-12 md:col-span-3 lg:col-span-3">
            <nav class="bg-white rounded-xl shadow-sm border p-4">
                <h2 class="text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wider">Menu</h2>
                <ul class="space-y-1 text-gray-700">
                    <li><a class="flex items-center gap-2 rounded-md px-3 py-2 hover:bg-gray-100" href="#"><span>Dashboard</span></a></li>
                    <li><a class="flex items-center gap-2 rounded-md px-3 py-2 hover:bg-gray-100" href="#"><span>Courses</span></a></li>
                    <li><a class="flex items-center gap-2 rounded-md px-3 py-2 hover:bg-gray-100" href="#"><span>Timetable</span></a></li>
                    <li><a class="flex items-center gap-2 rounded-md px-3 py-2 hover:bg-gray-100" href="#"><span>Profile</span></a></li>
                    <li><a class="flex items-center gap-2 rounded-md px-3 py-2 hover:bg-gray-100" href="#"><span>Settings</span></a></li>
                    <li class="pt-2 mt-2 border-t">
                        <a href="{{ route('confirmation') }}" class="flex items-center gap-2 rounded-md px-3 py-2 bg-brand-50 text-brand-700 hover:bg-brand-50/80">
                            <span>Apply for a temporary pass</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main content -->
        <main class="col-span-12 md:col-span-9 lg:col-span-9 space-y-6">
            <!-- Welcome / CTA -->
            <section class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Welcome back</h1>
                        <p class="mt-1 text-gray-600">This is a placeholder AMS dashboard. Replace content with real data later.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('confirmation') }}" class="inline-flex items-center justify-center rounded-md px-4 py-2 text-white text-sm font-medium hover:opacity-90" style="background-color:#0a3a8c">Apply for a temporary pass</a>
                        <button class="inline-flex items-center justify-center rounded-md border px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">View profile</button>
                    </div>
                </div>
            </section>

            <!-- Stats -->
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-sm border p-4">
                    <p class="text-xs text-gray-500">Applications</p>
                    <p class="mt-1 text-2xl font-semibold">12</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border p-4">
                    <p class="text-xs text-gray-500">Approved</p>
                    <p class="mt-1 text-2xl font-semibold text-green-600">7</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border p-4">
                    <p class="text-xs text-gray-500">Pending</p>
                    <p class="mt-1 text-2xl font-semibold text-amber-600">3</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border p-4">
                    <p class="text-xs text-gray-500">Rejected</p>
                    <p class="mt-1 text-2xl font-semibold text-red-600">2</p>
                </div>
            </section>

            <!-- Course categories (dummy, to mimic screenshot style) -->
            <section class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold" style="color:#b32428">Course categories</h2>
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Expand all</a>
                </div>
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $cats = [
                            ['name' => 'SCHOOL OF COMPUTING AND ENGINEERING SCIENCES', 'count' => 23],
                            ['name' => 'SCHOOL OF HUMANITIES AND SOCIAL SCIENCES', 'count' => 5],
                            ['name' => 'SCHOOL OF TOURISM AND HOSPITALITY', 'count' => 11],
                            ['name' => 'STRATHMORE INSTITUTE OF MANAGEMENT & TECHNOLOGY', 'count' => 10],
                            ['name' => 'STRATHMORE LAW SCHOOL', 'count' => 23],
                            ['name' => 'ILAB AFRICA', 'count' => 2],
                        ];
                    @endphp
                    @foreach ($cats as $c)
                        <a href="#" class="flex items-center justify-between rounded-2xl border bg-white px-4 py-4 shadow-sm hover:shadow transition">
                            <div class="flex items-center gap-3">
                                <span class="text-[18px]" style="color:#b32428">&#8250;</span>
                                <span class="text-sm sm:text-base font-semibold text-gray-800 uppercase tracking-wide">{{ $c['name'] }}</span>
                            </div>
                            <span class="inline-flex items-center justify-center rounded-pill text-white text-xs font-semibold h-7 px-3 shadow-sm" style="background-color:#0a3a8c">({{ $c['count'] }})</span>
                        </a>
                    @endforeach
                </div>
            </section>

            <!-- Table + Announcements -->
            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm border p-4 lg:col-span-2">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-900">Recent Requests (Dummy)</h3>
                        <button class="text-sm text-gray-600 hover:text-gray-900">View all</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 border-b">
                                    <th class="py-2 pr-4">ID</th>
                                    <th class="py-2 pr-4">Reason</th>
                                    <th class="py-2 pr-4">Status</th>
                                    <th class="py-2">Submitted</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                <tr>
                                    <td class="py-2 pr-4">#1001</td>
                                    <td class="py-2 pr-4">Guest lecture access</td>
                                    <td class="py-2 pr-4"><span class="rounded px-2 py-0.5 text-xs bg-amber-50 text-amber-700">Pending</span></td>
                                    <td class="py-2">Today</td>
                                </tr>
                                <tr>
                                    <td class="py-2 pr-4">#1000</td>
                                    <td class="py-2 pr-4">Library use</td>
                                    <td class="py-2 pr-4"><span class="rounded px-2 py-0.5 text-xs bg-green-50 text-green-700">Approved</span></td>
                                    <td class="py-2">Yesterday</td>
                                </tr>
                                <tr>
                                    <td class="py-2 pr-4">#0999</td>
                                    <td class="py-2 pr-4">Lab access</td>
                                    <td class="py-2 pr-4"><span class="rounded px-2 py-0.5 text-xs bg-red-50 text-red-700">Rejected</span></td>
                                    <td class="py-2">2 days ago</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-4">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Announcements</h3>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li class="flex gap-2"><span class="mt-1 h-2 w-2 rounded-full bg-green-500"></span><span>Semester registration opens next week.</span></li>
                        <li class="flex gap-2"><span class="mt-1 h-2 w-2 rounded-full bg-blue-500"></span><span>Maintenance on AMS this Friday 22:00–23:00.</span></li>
                        <li class="flex gap-2"><span class="mt-1 h-2 w-2 rounded-full bg-amber-500"></span><span>New ID policy effective from next month.</span></li>
                    </ul>
                </div>
            </section>

            <!-- Available courses (dummy thumbnails) -->
            <section class="bg-white rounded-xl shadow-sm border p-6">
                <h2 class="text-2xl font-bold" style="color:#b32428">Available courses</h2>
                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @for ($i = 0; $i < 8; $i++)
                        <a href="#" class="block rounded-xl overflow-hidden border shadow-sm hover:shadow">
                            <img src="https://placehold.co/249x200?text=Course+{{ $i+1 }}" alt="Course {{ $i+1 }}" class="w-full h-auto" />
                            <div class="p-3 text-sm font-semibold text-sublue-600">Course {{ $i+1 }}</div>
                        </a>
                    @endfor
                </div>
            </section>
        </main>
    </div>
    <!-- Footer (deep blue, three columns) -->
    <footer class="mt-10 text-white" style="background-color:#0a3a8c">
        <div class="mx-auto max-w-7xl px-4 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-3">
                    <img src="https://placehold.co/80x80" alt="University Logo" class="h-16 w-16" />
                    <span class="text-xl font-semibold">Strathmore University</span>
                </div>
                <p class="mt-4 text-sm text-white/90">Strathmore University is a leading University in the region, whose mission is to provide all‑round quality education in an atmosphere of freedom and responsibility; excellence in teaching, research, and scholarship; ethical and social development; and service to society. <a href="#" class="underline">Read More »</a></p>
            </div>
            <div>
                <h2 class="text-xl font-semibold">Info</h2>
                <ul class="mt-3 space-y-2 text-white/90">
                    <li><a href="#" class="underline">Library</a></li>
                    <li><a href="#" class="underline">Mail</a></li>
                    <li><a href="#" class="underline">Digital Repository</a></li>
                    <li><a href="#" class="underline">AMS Students' Module</a></li>
                    <li><a href="#" class="underline">Sagana</a></li>
                </ul>
            </div>
            <div>
                <h2 class="text-xl font-semibold">Contact Us</h2>
                <p class="mt-3 text-white/90 text-sm">Madaraka Estate Ole Sangale Road, PO Box 59857, 00200 City Square Nairobi, Kenya</p>
                <p class="mt-2 text-white/90 text-sm">Phone: (+254) (0)703‑034000 (+254) (0)703‑034200 (+254) (0)703‑034300</p>
                <p class="mt-1 text-white/90 text-sm">Email: <a href="mailto:systems@strathmore.edu" class="underline">systems@strathmore.edu</a></p>
            </div>
        </div>
        <div class="bg-black/10">
            <div class="mx-auto max-w-7xl px-4 py-3 text-center text-sm">Copyright © {{ now()->year }} - Strathmore University. All Rights Reserved.</div>
        </div>
    </footer>

    <!-- Floating buttons -->
    <a href="#top" class="fixed bottom-24 right-6 inline-flex items-center justify-center rounded-md text-white h-10 w-10 shadow" style="background-color:#0a3a8c" title="Back to top">▲</a>
    <a href="#" class="fixed bottom-6 right-6 inline-flex items-center justify-center rounded-full h-11 w-11 text-white shadow" style="background-color:#b32428" title="Help">?</a>

</body>
</html>
