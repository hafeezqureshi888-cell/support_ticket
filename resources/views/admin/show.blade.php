@extends('layouts.admin')

@section('title', 'Ticket Details')
@section('page-title', 'Ticket #' . $ticket->ticket_ref)
@section('page-subtitle', $ticket->subject)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Ticket Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Ticket Info Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-white">{{ $ticket->subject }}</h2>
                        <p class="text-orange-100 text-sm mt-1">{{ $ticket->ticket_type }}</p>
                    </div>
                    @if($ticket->status === 'Open')
                        <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-bold">Open</span>
                    @elseif($ticket->status === 'Noted')
                        <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-bold">Noted</span>
                    @else
                        <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-bold">Closed</span>
                    @endif
                </div>
            </div>
            
            <div class="p-6">
                <div class="prose max-w-none">
                    <h4 class="text-xs font-semibold text-gray-500 uppercase mb-2">Description</h4>
                    <p class="text-gray-800 whitespace-pre-wrap text-sm">{{ $ticket->description }}</p>
                </div>
            </div>
        </div>

        <!-- Admin Response -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-base font-bold text-gray-800 mb-4">Admin Response</h3>
            
            @if($ticket->admin_note)
                <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                    <p class="text-xs font-semibold text-blue-800 mb-2">Current Note:</p>
                    <div class="prose prose-sm max-w-none">{!! $ticket->admin_note !!}</div>
                </div>
            @endif

            <form method="POST" action="{{ url('/admin/ticket/' . $ticket->ticket_type . '/' . $ticket->id) }}">
                @csrf
                @method('PUT')
                
                @if($ticket->status !== 'Closed')
                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-700 mb-2">Add/Update Note</label>
                    <input id="admin_note" type="hidden" name="admin_note">
                    <trix-editor input="admin_note" class="border border-gray-300 rounded-lg"></trix-editor>
                </div>
                @endif

                <div class="flex flex-col sm:flex-row gap-3">
                    @if($ticket->status !== 'Closed')
                    <button type="submit" name="action" value="save_note" class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Save Note & Mark as Noted
                    </button>
                    @endif
                    
                    @if($ticket->status !== 'Closed')
                    <button type="submit" name="action" value="close_ticket" class="px-6 py-3 bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all"
                            onclick="return confirm('Are you sure you want to close this ticket?')">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Close Ticket
                    </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Customer Info -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-base font-bold text-gray-800 mb-4">Customer Information</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Name</p>
                    <p class="text-gray-900 font-medium text-sm">{{ $ticket->full_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Email</p>
                    <p class="text-gray-900 text-sm">{{ $ticket->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Phone</p>
                    <p class="text-gray-900 text-sm">{{ $ticket->phone ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Ticket Meta -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-base font-bold text-gray-800 mb-4">Ticket Details</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Reference</p>
                    <p class="text-gray-900 font-mono font-bold text-orange-600 text-sm">{{ $ticket->ticket_ref }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Type</p>
                    <p class="text-gray-900 text-sm">{{ $ticket->ticket_type }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Created</p>
                    <p class="text-gray-900 text-sm">{{ $ticket->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Last Updated</p>
                    <p class="text-gray-900 text-sm">{{ $ticket->updated_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <a href="{{ route('admin.dashboard') }}" class="block w-full text-center px-4 py-3 bg-gradient-to-r from-slate-600 to-slate-700 hover:from-slate-700 hover:to-slate-800 text-white rounded-lg font-medium transition-all shadow-md hover:shadow-lg">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
