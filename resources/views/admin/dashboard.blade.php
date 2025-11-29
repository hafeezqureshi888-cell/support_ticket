@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Ticket Dashboard')
@section('page-subtitle', 'View and manage all support tickets')

@section('extra-styles')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
@endsection

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-4 md:p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-xs md:text-sm font-medium">Open Tickets</p>
                <p class="text-2xl md:text-3xl font-bold mt-2">{{ $tickets->where('status', 'Open')->count() }}</p>
            </div>
            <div class="w-12 h-12 md:w-14 md:h-14 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-4 md:p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-xs md:text-sm font-medium">Noted Tickets</p>
                <p class="text-2xl md:text-3xl font-bold mt-2">{{ $tickets->where('status', 'Noted')->count() }}</p>
            </div>
            <div class="w-12 h-12 md:w-14 md:h-14 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-4 md:p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-red-100 text-xs md:text-sm font-medium">Closed Tickets</p>
                <p class="text-2xl md:text-3xl font-bold mt-2">{{ $tickets->where('status', 'Closed')->count() }}</p>
            </div>
            <div class="w-12 h-12 md:w-14 md:h-14 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Tickets Table -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200">
        <h3 class="text-base md:text-lg font-bold text-gray-800">All Support Tickets</h3>
        <p class="text-xs md:text-sm text-gray-500 mt-1">Manage and respond to customer inquiries</p>
    </div>
    
    <div class="overflow-x-auto">
        <table id="ticketsTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                    <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Type</th>
                    <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                    <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Customer</th>
                    <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Created</th>
                    <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($tickets as $ticket)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        <span class="font-mono text-xs font-semibold text-orange-600">{{ $ticket->ticket_ref }}</span>
                    </td>
                    <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-xs text-gray-900 hidden md:table-cell">{{ $ticket->ticket_type }}</td>
                    <td class="px-3 md:px-6 py-3 md:py-4 text-xs text-gray-900">{{ Str::limit($ticket->subject, 30) }}</td>
                    <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-xs text-gray-700 hidden lg:table-cell">{{ $ticket->full_name }}</td>
                    <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        @if($ticket->status === 'Open')
                            <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold border border-green-200">
                                Open
                            </span>
                        @elseif($ticket->status === 'Noted')
                            <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold border border-blue-200">
                                Noted
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold border border-red-200">
                                Closed
                            </span>
                        @endif
                    </td>
                    <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-xs text-gray-500 hidden md:table-cell">{{ $ticket->created_at->format('M d, Y') }}</td>
                    <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        <a href="{{ url('/admin/ticket/' . $ticket->ticket_type . '/' . $ticket->id) }}" 
                           class="inline-flex items-center px-2 md:px-3 py-1 md:py-1.5 bg-orange-500 hover:bg-orange-600 text-white text-xs rounded-md transition-colors font-medium">
                            <svg class="w-3 h-3 md:w-3.5 md:h-3.5 md:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <span class="hidden md:inline">View</span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#ticketsTable').DataTable({
            pageLength: 10,
            order: [[5, 'desc']],
            responsive: true,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_",
                info: "Showing _START_ to _END_ of _TOTAL_",
                infoEmpty: "No tickets",
                infoFiltered: "(filtered from _MAX_)"
            }
        });
    });
</script>
@endsection
