@extends('layout.app')

@section('content')

  <div class="max-w-lg mx-auto bg-gradient-to-br from-blue-50 to-white rounded-2xl shadow-xl p-8 mt-12 border border-blue-100">
    <h1 class="text-3xl font-extrabold text-blue-700 mb-8 text-center tracking-tight">University Member Application</h1>

    <form action="#" method="POST" class="space-y-6">
      <div>
        <label for="username" class="block text-base font-semibold text-gray-700 mb-2">Username</label>
        <input type="text" id="username" name="username"
               value="university.member"
               readonly
               class="w-full px-4 py-2 border border-blue-200 rounded-lg shadow-sm bg-gray-100 text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label for="email" class="block text-base font-semibold text-gray-700 mb-2">Email</label>
        <input type="email" id="email" name="email"
               value="member@university.edu"
               readonly
               class="w-full px-4 py-2 border border-blue-200 rounded-lg shadow-sm bg-gray-100 text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label for="reason" class="block text-base font-semibold text-gray-700 mb-2">Reason for Applying</label>
        <select id="reason" name="reason"
                class="w-full px-4 py-2 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
          <option value="" class="text-gray-400">Please select a reason...</option>
          <option value="lost_card">Lost/Forgotten ID Card</option>
          <option value="damaged_card">Damaged ID Card</option>
          <option value="campus_event">Attending special campus event</option>
          <option value="other">Other</option>
        </select>
      </div>

      <div>
        <button type="submit"
                class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-200 ease-in-out hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
          Apply
        </button>
      </div>
    </form>
  </div>

@endsection