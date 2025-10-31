@extends('layout.app')

@section('content')

  <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 mt-10">
    <h1 class="text-2xl font-bold mb-6">Apply for a Guest Pass</h1>

    <form action="#" method="POST"> <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
        <input type="text" id="name" name="name" 
               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" id="email" name="email" 
               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div class="mb-4">
        <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Photo (ID, Passport, etc.)</label>
        <input type="file" id="photo" name="photo" 
               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                      file:rounded-md file:border-0 file:font-semibold
                      file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
      </div>

      <div class="mb-6">
        <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Visit</label>
        <textarea id="reason" name="reason" rows="4"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
      </div>

      <div>
        <button type="submit" 
                class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-md 
                       hover:bg-blue-700 focus:outline-none focus:ring-2 
                       focus:ring-blue-500 focus:ring-offset-2">
          Submit Application
        </button>
      </div>
    </form>
  </div>

@endsection