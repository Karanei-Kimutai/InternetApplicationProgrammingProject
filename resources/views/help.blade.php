<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporary Pass Help & FAQ</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/tp-logo.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255,255,255,0.9); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-slate-50 to-blue-100 text-slate-800">

    <header class="w-full border-b border-slate-200 bg-white/90 sticky top-0 z-40 backdrop-blur">
        <div class="max-w-6xl mx-auto flex items-center justify-between px-5 py-4">
            <a href="{{ route('systemLandingPage') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/tp-logo.svg') }}" alt="Temporary Pass logo" class="h-12 w-auto drop-shadow">
                <div>
                    <p class="text-sm text-slate-500 uppercase tracking-wide">Temporary Pass</p>
                    <p class="text-base font-semibold text-slate-900">Help Center</p>
                </div>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('universityMemberLogin') }}" class="text-sm font-semibold text-[#0a3a8c] hover:text-[#0d4fb1]">Member Login</a>
                <a href="{{ route('visit.show') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900">Visitor Access</a>
                <a href="{{ route('systemLandingPage') }}" class="inline-flex items-center gap-2 rounded-full bg-[#0a3a8c] px-4 py-2 text-sm font-semibold text-white shadow hover:bg-[#0d4fb1] transition">
                    Back to portal
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-5 py-10">
        <div class="grid lg:grid-cols-[1fr_320px] gap-8">
            <section class="space-y-6">
                <div class="glass rounded-2xl shadow-lg p-6 border border-slate-100">
                    <p class="text-sm font-semibold text-[#0a3a8c] uppercase">Help & FAQ</p>
                    <h1 class="text-3xl font-bold text-slate-900 mt-1">Everything you need to know</h1>
                    <p class="text-slate-600 mt-2">Quick answers for submitting, tracking, and using your temporary pass—whether you are a university member or a guest.</p>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="glass rounded-2xl shadow p-6 border border-slate-100">
                        <h2 class="text-lg font-semibold text-slate-900">For university members</h2>
                        <ul class="mt-4 space-y-3 text-sm text-slate-700">
                            <li><span class="font-semibold text-[#0a3a8c]">How to apply:</span> Sign in with your university credentials, choose your reason, and submit the form.</li>
                            <li><span class="font-semibold text-[#0a3a8c]">Valid times:</span> Lost IDs last 7 days; other reasons last 24 hours.</li>
                            <li><span class="font-semibold text-[#0a3a8c]">Limits:</span> Lost/Misplaced ID can only be issued once every 30 days.</li>
                            <li><span class="font-semibold text-[#0a3a8c]">Need a new QR?</span> Reopen your confirmation email or ask security to reissue.</li>
                        </ul>
                    </div>

                    <div class="glass rounded-2xl shadow p-6 border border-slate-100">
                        <h2 class="text-lg font-semibold text-slate-900">For guests & visitors</h2>
                        <ul class="mt-4 space-y-3 text-sm text-slate-700">
                            <li><span class="font-semibold text-[#0a3a8c]">How to apply:</span> Use the Visit Us form with your name, email, and visit reason. Upload an ID photo if possible.</li>
                            <li><span class="font-semibold text-[#0a3a8c]">Approvals:</span> Security reviews requests during working hours. You will be emailed once approved.</li>
                            <li><span class="font-semibold text-[#0a3a8c]">Arrival:</span> Bring a photo ID. Show your QR code at the gate.</li>
                            <li><span class="font-semibold text-[#0a3a8c]">No email?</span> Check spam, then visit the security desk for assistance.</li>
                        </ul>
                    </div>
                </div>

                <div class="glass rounded-2xl shadow p-6 border border-slate-100">
                    <h2 class="text-xl font-semibold text-slate-900">Common questions</h2>
                    <dl class="mt-5 space-y-5 text-sm text-slate-700">
                        <div>
                            <dt class="font-semibold text-[#0a3a8c]">What if my QR code will not scan?</dt>
                            <dd class="mt-1">Increase screen brightness and clean the camera. If it still fails, the guard can verify your token manually or reissue a fresh QR.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-[#0a3a8c]">Can I change my visit date or reason?</dt>
                            <dd class="mt-1">Submit a new request with the correct details. Previous pending requests can be ignored; approved ones can be revoked by security if needed.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-[#0a3a8c]">How do I know when a pass expires?</dt>
                            <dd class="mt-1">The confirmation email shows validity times. Expired passes are automatically rejected and will not scan.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-[#0a3a8c]">What if I have no network at the gate?</dt>
                            <dd class="mt-1">Your QR can be shown offline from the email attachment. Guards can also verify the token on their portal.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-[#0a3a8c]">Who can approve passes?</dt>
                            <dd class="mt-1">Only authorized security/admin staff. Admins may revoke passes immediately if misuse is detected.</dd>
                        </div>
                    </dl>
                </div>
            </section>

            <aside class="space-y-4">
                <div class="glass rounded-2xl shadow p-6 border border-slate-100">
                    <h3 class="text-base font-semibold text-slate-900">Quick actions</h3>
                    <div class="mt-4 space-y-3">
                        <a href="{{ route('apply.student') }}" class="block w-full text-center rounded-lg bg-[#0a3a8c] px-4 py-3 text-sm font-semibold text-white hover:bg-[#0d4fb1] shadow">Apply as Member</a>
                        <a href="{{ route('apply.guest') }}" class="block w-full text-center rounded-lg bg-slate-800 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-700 shadow">Apply as Guest</a>
                        <a href="{{ route('security.login') }}" class="block w-full text-center rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-800 hover:border-[#0a3a8c] hover:text-[#0a3a8c] transition">Security Portal</a>
                    </div>
                </div>

                <div class="glass rounded-2xl shadow p-6 border border-slate-100">
                    <h3 class="text-base font-semibold text-slate-900">Need more help?</h3>
                    <p class="mt-2 text-sm text-slate-700">Visit the security desk on campus or email the security office with your admission number/visit reference.</p>
                    <ul class="mt-3 space-y-2 text-sm text-slate-700">
                        <li><span class="font-semibold text-[#0a3a8c]">Email:</span> securityoffice@example.edu</li>
                        <li><span class="font-semibold text-[#0a3a8c]">Hours:</span> Mon–Fri, 8:00–18:00</li>
                    </ul>
                </div>
            </aside>
        </div>
    </main>

    <footer class="border-t border-slate-200 bg-white/90">
        <div class="max-w-6xl mx-auto px-5 py-6 flex flex-col md:flex-row items-center justify-between text-sm text-slate-600">
            <p>&copy; {{ date('Y') }} Temporary Pass Application System</p>
            <div class="flex items-center gap-4 mt-2 md:mt-0">
                <a href="{{ route('publicSite.show') }}" class="hover:text-[#0a3a8c]">Main site</a>
                <a href="{{ route('visit.show') }}" class="hover:text-[#0a3a8c]">Visitor access</a>
                <a href="{{ route('help.show') }}" class="hover:text-[#0a3a8c]">Help & FAQ</a>
            </div>
        </div>
    </footer>

</body>
</html>
