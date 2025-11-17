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
<body class="min-h-screen bg-gradient-to-b from-slate-50 via-white to-slate-100 font-sans antialiased py-12 px-4">
@php
    $statusMessage = session('status') ?? 'Temporary pass issued successfully.';
    $qrToken = session('qr_token');
    $passReference = $qrToken ? strtoupper(substr($qrToken, 0, 8)) : 'Pending';
    $timezone = config('app.timezone', 'UTC');
    $validFrom = session('valid_from') ? \Carbon\Carbon::parse(session('valid_from'))->timezone($timezone)->format('D, d M Y g:i A') : 'Awaiting activation';
    $validUntil = session('valid_until') ? \Carbon\Carbon::parse(session('valid_until'))->timezone($timezone)->format('D, d M Y g:i A') : 'Awaiting activation';
    $emailHint = session('member_email') ?? 'your university email';
@endphp
    <main class="max-w-4xl mx-auto">
        <div class="rounded-[32px] bg-white shadow-2xl ring-1 ring-black/5 overflow-hidden">
            <header class="bg-gradient-to-r from-blue-900 via-blue-800 to-blue-600 px-10 py-8 text-white">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-blue-200">Temporary Pass Confirmation</p>
                        <h1 class="mt-2 text-3xl font-semibold">You're all set.</h1>
                        <p class="mt-2 text-sm text-blue-100 max-w-2xl">{{ $statusMessage }}</p>
                    </div>
                    <div class="bg-white/10 rounded-2xl px-6 py-4 backdrop-blur text-sm">
                        <p class="text-blue-100">QR + instructions sent to</p>
                        <p class="text-base font-semibold text-white">{{ $emailHint }}</p>
                    </div>
                </div>
            </header>

            <section class="px-10 py-8 space-y-8">
                <div class="grid gap-6 md:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 p-5 shadow-sm">
                        <p class="text-xs uppercase tracking-wide text-slate-500">Pass reference</p>
                        <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $passReference }}</p>
                        <p class="mt-2 text-xs text-slate-500">Matches the code in your email receipt.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 p-5 shadow-sm">
                        <p class="text-xs uppercase tracking-wide text-slate-500">Valid window</p>
                        <p class="mt-3 text-base font-medium text-slate-900">{{ $validFrom }}</p>
                        <p class="text-slate-400 text-sm">to</p>
                        <p class="text-base font-medium text-slate-900">{{ $validUntil }}</p>
                        <p class="mt-2 text-xs text-slate-500">Lost IDs last 7 days; other reasons 24 hours.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 p-5 shadow-sm bg-slate-50">
                        <p class="text-xs uppercase tracking-wide text-slate-500">Rate limit</p>
                        <p class="mt-3 text-sm text-slate-800">Lost/Misplaced ID requests are limited to once every 30 days. Security can reset this if needed.</p>
                    </div>
                </div>

                @if (session('qr_url'))
                    <div class="rounded-3xl border border-blue-100 bg-gradient-to-r from-blue-50 via-white to-blue-50 p-6 shadow-inner flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-blue-900">Need the QR right away?</h2>
                            <p class="text-sm text-blue-700 max-w-2xl">The code is already in your inbox, but you can open it instantly using the buttons below. Please do not share the QR outside official security staff.</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ session('qr_url') }}" target="_blank" rel="noopener"
                               class="inline-flex items-center rounded-2xl bg-blue-600 px-5 py-2.5 text-white text-sm font-medium shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                View QR
                            </a>
                            @if (session('verify_url'))
                                <a href="{{ session('verify_url') }}" target="_blank" rel="noopener"
                                   class="inline-flex items-center rounded-2xl bg-white px-5 py-2.5 text-sm font-medium text-blue-700 shadow hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-200">
                                    Verify token
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-800 uppercase tracking-wide">Before you arrive</p>
                    <ol class="mt-4 space-y-4 text-sm text-slate-600">
                        <li class="flex gap-3">
                            <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-900 text-xs font-semibold text-white">1</span>
                            Present your student ID receipt and the emailed QR code to the security team. Screenshots are acceptable.
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-900 text-xs font-semibold text-white">2</span>
                            Arrive 10 minutes early to allow QR scanning and identity verification at the gate.
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-900 text-xs font-semibold text-white">3</span>
                            Need adjustments? Reply to the confirmation email or visit the security office for manual assistance.
                        </li>
                    </ol>
                </div>

                <div class="flex flex-col gap-3 md:flex-row md:justify-end">
                    <a href="{{ route('ams.dashboard') }}"
                       class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-6 py-3 text-white font-medium shadow hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500">
                        Return to AMS dashboard
                    </a>
                    <a href="{{ route('tpas.members.apply') }}"
                       class="inline-flex items-center justify-center rounded-2xl border border-slate-200 px-6 py-3 text-slate-800 font-medium shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-200">
                        Submit another request
                    </a>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
