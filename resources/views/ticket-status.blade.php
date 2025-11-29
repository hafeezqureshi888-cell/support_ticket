@extends('layouts.app')

@section('title', 'Ticket Status')

@section('content')
<div class="w-full md:max-w-2xl md:mx-auto">
    <div class="bg-white rounded-lg shadow-md p-4 md:p-8">
        <h1 class="mb-6 text-2xl font-semibold text-gray-800">Ticket Details</h1>

        <div class="bg-gray-50 p-6 rounded-lg mb-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $ticket->subject }}</h2>
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ $ticket->ticket_ref }}</span>
                        <span>{{ $ticket->ticket_type }}</span>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $ticket->status === 'Open' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                    {{ $ticket->status }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-500">Submitted By</p>
                    <p class="font-medium text-gray-900">{{ $ticket->full_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium text-gray-900">{{ $ticket->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="font-medium text-gray-900">{{ $ticket->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Submitted On</p>
                    <p class="font-medium text-gray-900">{{ $ticket->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-500 mb-2">Description</p>
                <div class="bg-white p-4 rounded border border-gray-200">
                    <p class="text-gray-800 whitespace-pre-wrap">{{ $ticket->description }}</p>
                </div>
            </div>

            @if($ticket->admin_note)
            <div class="border-t pt-4">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-semibold text-gray-700">Status Update</p>
                </div>
                <div class="bg-blue-50 p-4 rounded border border-blue-200">
                    <div class="prose prose-sm max-w-none">{!! $ticket->admin_note !!}</div>
                </div>
            </div>
            @else
            <div class="border-t pt-4">
                <div class="flex items-center gap-2 text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm italic">Your ticket is being reviewed. We'll update you soon!</p>
                </div>
            </div>
            @endif
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="/check-status" class="flex-1 text-center bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                Check Another Ticket
            </a>
            <a href="/" class="flex-1 text-center btn-gradient text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transition-all">
                Submit New Ticket
            </a>
        </div>
    </div>
</div>
@endsection
