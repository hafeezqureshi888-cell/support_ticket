@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="w-full md:max-w-md md:mx-auto">
    <div class="bg-white rounded-xl shadow-2xl p-8 md:p-10">
        <div class="text-center mb-8">
            <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.040A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Admin Login</h2>
            <p class="text-gray-500">Access the support ticket dashboard</p>
        </div>
        
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p class="text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ url('/admin/login') }}" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2" for="email">
                    Email Address
                </label>
                <input class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all" 
                    id="email" type="email" name="email" placeholder="admin@example.com" required autofocus>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2" for="password">
                    Password
                </label>
                <input class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all" 
                    id="password" type="password" name="password" placeholder="••••••••" required>
            </div>
            
            <button class="w-full btn-gradient text-white font-semibold py-3.5 rounded-lg shadow-lg hover:shadow-xl transition-all" type="submit">
                Sign In to Dashboard
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="/" class="text-sm text-orange-600 hover:text-orange-700 font-medium">
                ← Back to Support Portal
            </a>
        </div>
    </div>
</div>
@endsection
