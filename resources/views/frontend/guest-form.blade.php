@extends('layout.app')

@section('content')

  <div class="max-w-lg mx-auto bg-gradient-to-br from-blue-50 to-white rounded-2xl shadow-xl p-8 mt-12 border border-blue-100">
    <h1 class="text-3xl font-extrabold text-blue-700 mb-8 text-center tracking-tight">Apply for a Guest Pass</h1>

    <form action="#" method="POST" class="space-y-6">
      <div>
        <label for="name" class="block text-base font-semibold text-gray-700 mb-2">Name</label>
        <input type="text" id="name" name="name"
               class="w-full px-4 py-2 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label for="email" class="block text-base font-semibold text-gray-700 mb-2">Email</label>
        <input type="email" id="email" name="email"
               class="w-full px-4 py-2 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label for="photo" class="block text-base font-semibold text-gray-700 mb-2">Photo (ID, Passport, etc.)</label>
        <input type="file" id="photo" name="photo"
               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
      </div>

      <div>
        <label for="reason" class="block text-base font-semibold text-gray-700 mb-2">Reason for Visit</label>
        <textarea id="reason" name="reason" rows="4"
                  class="w-full px-4 py-2 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
      </div>

      <div>
        <button type="submit"
                class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-200 ease-in-out hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
          Submit Application
        </button>
      </div>
    </form>
  </div>

@endsection