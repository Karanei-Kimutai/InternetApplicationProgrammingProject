@extends('layout.app')

@section('content')

  <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 mt-10">
    <h1 class="text-2xl font-bold mb-6">University Member Application</h1>

    <form action="#" method="POST">
      <div class="mb-4">
        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
        <input type="text" id="username" name="username" 
               
               value="university.member" 
               
               readonly  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                      bg-gray-100 focus:outline-none"> </div>

      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" id="email" name="email" 
               
               value="member@university.edu" 
               
               readonly
               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                      bg-gray-100 focus:outline-none">
      </div>

      <div class="mb-6">
        <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Applying</label>
        <select id="reason" name="reason"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                       focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          
          <option value="">Please select a reason...</option>
          <option value="lost_card">Lost/Forgotten ID Card</option>
          <option value="damaged_card">Damaged ID Card</option>
          <option value="campus_event">Attending special campus event</option>
          <option value="other">Other</option>
        
        </select>
      </div>

      <div>
        <button type="submit" 
                class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-md 
                       hover:bg-blue-700 focus:outline-none focus:ring-2 
                       focus:ring-blue-500 focus:ring-offset-2">
          Apply
        </button>
      </div>
    </form>
  </div>

@endsection