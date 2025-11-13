<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Control Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
</head>
<body class="bg-slate-100 font-sans antialiased">
<div x-data="{ queueTab: 'members' }" class="min-h-screen">
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-blue-600">Admin Command Center</p>
                <h1 class="text-2xl font-semibold text-slate-900">Temporary Pass Operations</h1>
                <p class="text-sm text-slate-500 mt-1">Monitor queues, manage approvals, and unblock members.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <form action="{{ route('admin.member.reset') }}" method="POST" class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-2xl px-3 py-2">
                    @csrf
                    <label for="member_id" class="text-xs tracking-wide text-slate-500">Reset rate limit</label>
                    <input type="number" name="member_id" id="member_id" min="1" placeholder="Admission #" class="w-32 rounded-xl border border-slate-200 px-3 py-1 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-amber-500 text-white text-xs font-semibold hover:bg-amber-600">Reset</button>
                </form>
                <form action="{{ route('adminLogout') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Log out
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 shadow">
                {{ session('error') }}
            </div>
        @endif

        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <article class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-slate-400">University passes</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $statistics['university_count'] ?? 0 }}</p>
                <p class="text-xs text-slate-500 mt-1">total submissions</p>
            </article>
            <article class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-slate-400">Guest passes</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $statistics['guest_count'] ?? 0 }}</p>
                <p class="text-xs text-slate-500 mt-1">total submissions</p>
            </article>
            <article class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-slate-400">Pending reviews</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">
                    {{ $universityApplications->where('status','pending')->count() + $guestApplications->where('status','pending')->count() }}
                </p>
                <p class="text-xs text-slate-500 mt-1">awaiting action</p>
            </article>
            <article class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-slate-400">Archived passes</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $statistics['archived_count'] ?? 0 }}</p>
                <p class="text-xs text-slate-500 mt-1">soft-deleted records</p>
            </article>
            <article class="rounded-3xl bg-gradient-to-br from-blue-600 to-indigo-500 p-5 text-white shadow-lg">
                <p class="text-xs uppercase tracking-wide text-white/70">Today’s focus</p>
                <p class="mt-2 text-lg font-semibold">Resolve all pending requests</p>
                <p class="text-xs text-indigo-100 mt-2">Aim for sub 10-minute response times.</p>
            </article>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-blue-500">Review queue</p>
                            <h2 class="text-xl font-semibold text-slate-900">Prioritize pending passes</h2>
                        </div>
                        <div class="flex rounded-full border border-slate-200 bg-slate-50 p-1 text-xs font-semibold text-slate-500">
                            <button @click="queueTab = 'members'" :class="queueTab === 'members' ? 'bg-white text-blue-600 shadow' : ''" class="px-4 py-1.5 rounded-full transition">Members</button>
                            <button @click="queueTab = 'guests'" :class="queueTab === 'guests' ? 'bg-white text-blue-600 shadow' : ''" class="px-4 py-1.5 rounded-full transition">Guests</button>
                        </div>
                    </div>

                    <div class="mt-6 divide-y divide-slate-100">
                        @php
                            $memberQueue = $universityApplications->take(8);
                            $guestQueue = $guestApplications->take(8);
                        @endphp
                        <template x-if="queueTab === 'members'">
                            <div>
                                @forelse ($memberQueue as $application)
                                    <div class="py-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">{{ $application->passable->name ?? 'Unknown member' }}</p>
                                            <p class="text-xs text-slate-500 uppercase tracking-wide">Reason · {{ $application->reason_label }}</p>
                                            <p class="text-xs text-slate-400 mt-1">Requested {{ optional($application->created_at)->diffForHumans() }}</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs px-3 py-1.5 rounded-full {{ $application->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600' }} capitalize">
                                                {{ $application->status }}
                                            </span>
                                            @if($application->status === 'pending')
                                                <form action="{{ route('admin.pass.approve', $application->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-500 text-white text-xs font-semibold hover:bg-emerald-600">Approve</button>
                                                </form>
                                                <form action="{{ route('admin.pass.reject', $application->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-red-500 text-white text-xs font-semibold hover:bg-red-600">Reject</button>
                                                </form>
                                            @endif
                                            @if($application->status !== 'approved' || optional($application->valid_until)->isPast())
                                                <form action="{{ route('admin.pass.destroy', $application->id) }}" method="POST" onsubmit="return confirm('Archive this pass? This cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-300">Archive</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="py-6 text-sm text-slate-500">No member requests in the queue.</p>
                                @endforelse
                            </div>
                        </template>

                        <template x-if="queueTab === 'guests'">
                            <div>
                                @forelse ($guestQueue as $application)
                                    <div class="py-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">{{ $application->passable->name ?? 'Unknown guest' }}</p>
                                            <p class="text-xs text-slate-500 uppercase tracking-wide">Reason · {{ $application->reason_label }}</p>
                                            <p class="text-xs text-slate-400 mt-1">Requested {{ optional($application->created_at)->diffForHumans() }}</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs px-3 py-1.5 rounded-full {{ $application->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600' }} capitalize">
                                                {{ $application->status }}
                                            </span>
                                            @if($application->status === 'pending')
                                                <form action="{{ route('admin.pass.approve', $application->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-500 text-white text-xs font-semibold hover:bg-emerald-600">Approve</button>
                                                </form>
                                                <form action="{{ route('admin.pass.reject', $application->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-red-500 text-white text-xs font-semibold hover:bg-red-600">Reject</button>
                                                </form>
                                            @endif
                                            @if($application->status !== 'approved' || optional($application->valid_until)->isPast())
                                                <form action="{{ route('admin.pass.destroy', $application->id) }}" method="POST" onsubmit="return confirm('Archive this pass? This cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-300">Archive</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="py-6 text-sm text-slate-500">No guest requests in the queue.</p>
                                @endforelse
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Recent activity</p>
                    <ul class="mt-4 space-y-4 text-sm text-slate-600">
                        @php
                            $activity = $universityApplications->merge($guestApplications)
                                ->sortByDesc('updated_at')
                                ->take(6);
                        @endphp
                        @forelse ($activity as $item)
                            <li class="flex justify-between">
                                <div>
                                    <span class="font-semibold text-slate-900">{{ $item->passable->name ?? 'Unknown' }}</span>
                                    <span class="text-slate-400">· {{ ucfirst($item->status) }}</span>
                                    <p class="text-xs text-slate-500">{{ $item->reason_label }}</p>
                                </div>
                                <span class="text-xs text-slate-400">{{ optional($item->updated_at)->diffForHumans() }}</span>
                            </li>
                        @empty
                            <li class="text-slate-500 text-sm">No recent activity logged.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Admin notes</p>
                    <ul class="mt-3 list-disc list-inside space-y-2 text-sm text-slate-600">
                        <li>Clear pending approvals before end of day to avoid gate delays.</li>
                        <li>Use the rate-limit reset tool sparingly and always log manual overrides.</li>
                        <li>Monitor email logs for any failed deliveries and resubmit if needed.</li>
                    </ul>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Archived passes</p>
                        <span class="text-xs text-slate-400">{{ $statistics['archived_count'] ?? 0 }} total</span>
                    </div>
                    <ul class="mt-4 space-y-4 text-sm text-slate-600">
                        @forelse ($archivedPasses as $archived)
                            <li class="rounded-2xl border border-slate-100 p-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $archived->passable->name ?? 'Unknown' }}</p>
                                        <p class="text-xs text-slate-500 uppercase tracking-wide">{{ $archived->reason_label }}</p>
                                        <p class="text-xs text-slate-400">Archived {{ optional($archived->deleted_at)->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <form action="{{ route('admin.pass.restore', $archived->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full rounded-xl bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 hover:bg-emerald-200">Restore</button>
                                        </form>
                                        <form action="{{ route('admin.pass.purge', $archived->id) }}" method="POST" onsubmit="return confirm('Permanently delete this pass? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full rounded-xl bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 hover:bg-red-200">Purge</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-slate-500 text-sm">No archived passes yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </section>
    </main>
</div>
</body>
</html>
