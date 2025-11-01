@extends('layout.app')

@section('content')

  <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl mt-12 border overflow-hidden">

    <!-- Header -->
    <div class="px-8 pt-8 pb-4 flex items-start gap-4">
      <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center ring-1 ring-blue-200">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6 text-blue-700"><path d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Z"/><path fill-rule="evenodd" d="M8.25 9a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 .75.75v6a.75.75 0 0 1-.75.75h-6a.75.75 0 0 1-.75-.75V9Zm1.5.75v4.5h4.5v-4.5h-4.5Z" clip-rule="evenodd"/></svg>
      </div>
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Temporary Pass Application</h1>
        <p class="text-gray-600">University member short-term access request.</p>
      </div>
    </div>

    <!-- Body -->
    <div class="px-8 pb-8">
      <div class="mb-6 rounded-lg bg-blue-50 text-blue-900 border border-blue-100 px-4 py-3 text-sm">
        Your details are pre-filled from AMS. Review and select a reason.
      </div>

      <form action="{{ route('tpas.members.submit') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf

        <!-- Username (readonly) -->
        <div class="md:col-span-1">
          <label for="member_username" class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
          <div class="relative">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M12 12c2.485 0 4.5-2.015 4.5-4.5S14.485 3 12 3 7.5 5.015 7.5 7.5 9.515 12 12 12Z"/><path d="M4.5 20.25a7.5 7.5 0 0 1 15 0V21a.75.75 0 0 1-.75.75h-13.5A.75.75 0 0 1 4.5 21v-.75Z"/></svg>
            </span>
            <input type="text" id="member_username" name="member_username" value="{{ session('member_username') }}" readonly
              class="w-full pl-10 pr-3 py-2 border rounded-lg shadow-sm bg-gray-100 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
          </div>
          <p class="mt-1 text-xs text-gray-500">Read-only (synced from AMS)</p>
        </div>

        <!-- Email (readonly) -->
        <div class="md:col-span-1">
          <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
          <div class="relative">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25H4.5a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5H4.5a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.31 0L3.32 8.91A2.25 2.25 0 0 1 2.25 6.993V6.75" />
              </svg>
            </span>
            <input type="email" id="email" name="email" value="{{ session('member_email') }}" readonly
              class="w-full pl-10 pr-3 py-2 border rounded-lg shadow-sm bg-gray-100 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
          </div>
          <p class="mt-1 text-xs text-gray-500">Read-only (synced from AMS)</p>
        </div>

        <!-- Removed Admission ID field per request -->

        <!-- Reason -->
        <div class="md:col-span-2">
          <label for="reason" class="block text-sm font-semibold text-gray-700 mb-2">Reason for Applying</label>
          <div class="relative">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path fill-rule="evenodd" d="M12 3.75a8.25 8.25 0 1 0 0 16.5 8.25 8.25 0 0 0 0-16.5ZM10.5 9a1.5 1.5 0 1 1 3 0v3a1.5 1.5 0 1 1-3 0V9Zm1.5 7.5a1.125 1.125 0 1 1 0-2.25 1.125 1.125 0 0 1 0 2.25Z" clip-rule="evenodd"/></svg>
            </span>
            <select id="reason" name="reason" class="w-full pl-10 pr-10 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 appearance-none">
              <option value="" class="text-gray-400">Please select a reason...</option>
              <option value="lost_card">Lost/Forgotten ID Card</option>
              <option value="damaged_card">Damaged ID Card</option>
              <option value="campus_event">Attending special campus event</option>
              <option value="other">Other</option>
            </select>
            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path fill-rule="evenodd" d="M12 14.25a.75.75 0 0 1-.53-.22l-4.5-4.5a.75.75 0 1 1 1.06-1.06L12 12.44l3.97-3.97a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-.53.22Z" clip-rule="evenodd"/></svg>
            </span>
          </div>
        </div>

        <!-- Actions -->
        <div class="md:col-span-2 flex items-center justify-between pt-2">
          <a href="{{ route('ams.dashboard') }}" class="inline-flex items-center rounded-md px-5 py-2.5 text-gray-900 bg-gray-100 hover:bg-gray-200">
            Back to Dashboard
          </a>
          <button type="submit" class="inline-flex items-center rounded-md px-6 py-3 text-white" style="background-color:#0a3a8c">
            Submit Application
          </button>
        </div>
      </form>

      <div class="mt-6 text-xs text-gray-500">
        By submitting, you agree to TPAS terms and privacy. Need a guest pass instead?
        <a href="{{ route('tpas.guest.apply') }}" class="text-blue-600 hover:underline">Apply as Guest</a>.
      </div>
    </div>
  </div>

@endsection
