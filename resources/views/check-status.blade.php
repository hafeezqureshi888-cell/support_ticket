@extends('layouts.app')

@section('title', 'Check Ticket Status')

@section('content')
<div class="w-full md:max-w-xl md:mx-auto">
    <div class="bg-white rounded-lg shadow-md p-4 md:p-8">
        <h1 class="mb-6 md:mb-8 text-lg md:text-xl font-semibold text-gray-800">Check Ticket Status</h1>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 p-3 rounded text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('ticket.status.check') }}" class="space-y-5">
            @csrf
            
            <div>
                <label for="email" class="block mb-2 text-sm text-gray-700">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Enter your email address"
                    class="w-full px-3 py-3 md:px-4 md:py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors" required/>
            </div>

            <div>
                <label for="ticket_ref" class="block mb-2 text-sm text-gray-700">
                    Ticket Reference <span class="text-red-500">*</span>
                </label>
                <input id="ticket_ref" name="ticket_ref" type="text" value="{{ old('ticket_ref') }}" placeholder="e.g., TKT-A1B2C3"
                    class="w-full px-3 py-3 md:px-4 md:py-2.5 text-sm font-mono border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors" required/>
            </div>

            <button type="submit" class="w-full btn-gradient text-white py-3 md:py-3 rounded-lg font-medium shadow-lg mt-6 hover:shadow-xl transition-all text-sm font-semibold">
                Check Status
            </button>
        </form>
    </div>
</div>
@endsection
