<div class="mb-6">
    <div class="bg-white/60 backdrop-blur-lg border border-white/50 shadow-xl sm:rounded-2xl mb-6 overflow-hidden">
        <div class="p-6 text-gray-900 flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left border-b border-white/50">
            <div>
                <h3 class="text-2xl font-bold text-indigo-900 mb-2">Welcome Dr. {{ auth()->user()->name }}!</h3>
                <p class="text-gray-700">Here is a quick overview of your schedule.</p>
                @php
                    $avgRating = auth()->user()->reviewsReceived()->avg('rating') ?? 0;
                    $reviewCount = auth()->user()->reviewsReceived()->count();
                @endphp
                @if($reviewCount > 0)
                    <div class="mt-2 flex items-center gap-1 bg-white/50 backdrop-blur-sm inline-flex px-3 py-1 rounded-full shadow-sm border border-white/50">
                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <span class="text-gray-900 font-bold text-sm">{{ number_format($avgRating, 1) }}</span>
                        <span class="text-gray-600 text-xs">({{ $reviewCount }} reviews)</span>
                    </div>
                @endif
            </div>
            
            <a href="{{ route('messages.index') }}" class="relative inline-flex items-center p-3 text-sm font-medium text-center text-white bg-indigo-600/90 backdrop-blur-sm rounded-xl hover:bg-indigo-700 shadow-md transition">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                <span class="sr-only">Messages</span>
                @if($unreadMessages > 0)
                    <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -right-2">{{ $unreadMessages }}</div>
                @endif
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white/60 backdrop-blur-md border border-white/50 shadow-lg sm:rounded-2xl p-6 border-l-4 border-l-yellow-400 relative overflow-hidden">
            <div class="text-gray-600 text-sm font-bold uppercase tracking-wider mb-1">Pending Requests</div>
            <div class="text-4xl font-extrabold text-gray-900">{{ $totalPending }}</div>
            <div class="absolute -bottom-4 -right-4 text-yellow-400 opacity-20">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
            </div>
        </div>
        <div class="bg-white/60 backdrop-blur-md border border-white/50 shadow-lg sm:rounded-2xl p-6 border-l-4 border-l-green-500 relative overflow-hidden">
            <div class="text-gray-600 text-sm font-bold uppercase tracking-wider mb-1">Accepted (Upcoming)</div>
            <div class="text-4xl font-extrabold text-gray-900">{{ $totalAccepted }}</div>
            <div class="absolute -bottom-4 -right-4 text-green-500 opacity-20">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            </div>
        </div>
        <div class="bg-white/60 backdrop-blur-md border border-white/50 shadow-lg sm:rounded-2xl p-6 border-l-4 border-l-blue-500 relative overflow-hidden">
            <div class="text-gray-600 text-sm font-bold uppercase tracking-wider mb-1">Completed</div>
            <div class="text-4xl font-extrabold text-gray-900">{{ $totalCompleted }}</div>
            <div class="absolute -bottom-4 -right-4 text-blue-500 opacity-20">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.441A11.026 11.026 0 002 10c0 5.523 4.477 10 10 10a10.947 10.947 0 005.94-1.758c-.901.492-2.146.758-3.44.758-3.86 0-7-3.14-7-7s3.14-7 7-7c1.294 0 2.539.266 3.44.758z" clip-rule="evenodd"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Manage Schedule / Unavailability -->
<div class="bg-white/60 backdrop-blur-lg border border-white/50 shadow-xl sm:rounded-2xl mb-6 overflow-hidden">
    <div class="p-6">
        <h4 class="text-lg font-bold mb-4 text-indigo-900 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Manage Schedule & Leaves
        </h4>
        
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100/80 border border-red-200 text-red-700 rounded-lg">
                <ul class="list-disc list-inside text-sm font-semibold">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('doctor.unavailabilities.store') }}" class="mb-6 bg-white/40 p-4 rounded-xl border border-white/50 shadow-sm flex flex-col md:flex-row gap-4 items-end">
            @csrf
            <div class="w-full md:w-1/4">
                <label for="start_date" class="block text-sm font-bold text-gray-700 mb-1">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="w-full bg-white/50 border-white/50 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm backdrop-blur-sm" required min="{{ date('Y-m-d') }}">
            </div>
            <div class="w-full md:w-1/4">
                <label for="end_date" class="block text-sm font-bold text-gray-700 mb-1">End Date</label>
                <input type="date" id="end_date" name="end_date" class="w-full bg-white/50 border-white/50 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm backdrop-blur-sm" required min="{{ date('Y-m-d') }}">
            </div>
            <div class="w-full md:w-1/3">
                <label for="reason" class="block text-sm font-bold text-gray-700 mb-1">Reason (Optional)</label>
                <input type="text" id="reason" name="reason" placeholder="e.g., Vacation, Conference" class="w-full bg-white/50 border-white/50 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm backdrop-blur-sm">
            </div>
            <div class="w-full md:w-auto">
                <button type="submit" class="w-full bg-indigo-600/90 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow text-sm font-bold backdrop-blur-sm transition">
                    Block Dates
                </button>
            </div>
        </form>

        @if(isset($unavailabilities) && $unavailabilities->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/30">
                    <thead class="bg-white/40 backdrop-blur-sm border-b border-white/50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Dates</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Reason</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-gray-700 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/30">
                        @foreach($unavailabilities as $unavailability)
                            <tr class="hover:bg-white/20 transition">
                                <td class="px-4 py-3 text-sm font-bold text-gray-900">
                                    {{ $unavailability->start_date->format('M d, Y') }} 
                                    @if($unavailability->start_date != $unavailability->end_date)
                                        - {{ $unavailability->end_date->format('M d, Y') }}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $unavailability->reason ?? 'Not specified' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-right">
                                    <form method="POST" action="{{ route('doctor.unavailabilities.destroy', $unavailability) }}" onsubmit="return confirm('Are you sure you want to delete this blocked date range?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-xs">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-gray-500 italic">No upcoming blocked dates.</p>
        @endif
    </div>
</div>

@if($todayAppointments->isNotEmpty())
<!-- Today's Appointments -->
<div class="bg-white/60 backdrop-blur-lg border border-white/50 shadow-xl sm:rounded-2xl mb-6 overflow-hidden">
    <div class="p-6">
        <h4 class="text-lg font-bold mb-4 text-indigo-900 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Today's Schedule
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($todayAppointments as $app)
                <div class="bg-white/50 backdrop-blur-sm p-4 rounded-xl shadow-sm border border-white/50 border-l-4 {{ $app->status === 'completed' ? 'border-l-blue-500 opacity-75' : 'border-l-indigo-500' }}">
                    <div class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($app->appointment_time)->format('h:i A') }}</div>
                    <div class="text-sm font-medium mt-1">{{ $app->patient->first_name }} {{ $app->patient->name }}</div>
                    <div class="mt-3 flex gap-2">
                        @if($app->status === 'accepted')
                            <form method="POST" action="{{ route('appointments.updateStatus', $app) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="text-xs text-blue-800 hover:text-blue-900 font-semibold bg-blue-100/80 px-2 py-1 rounded-md border border-blue-200">Mark Completed</button>
                            </form>
                        @else
                            <span class="text-xs text-gray-600 italic">Completed</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- All Appointments -->
<div class="bg-white/60 backdrop-blur-lg border border-white/50 shadow-xl sm:rounded-2xl overflow-hidden mb-8">
    <div class="p-6 border-b border-white/50 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-4">
            <h4 class="text-xl font-bold text-gray-900">All Appointments</h4>
            <a href="{{ route('export.doctor.schedule') }}" class="inline-flex items-center px-3 py-1.5 bg-white/50 border border-indigo-200 rounded-lg font-semibold text-xs text-indigo-700 uppercase tracking-widest hover:bg-indigo-50 transition ease-in-out duration-150 shadow-sm backdrop-blur-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export Schedule (PDF)
            </a>
        </div>
        
        <!-- Filter Form -->
        <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto mt-4 md:mt-0">
            <select name="status" class="bg-white/50 border-white/50 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm backdrop-blur-sm w-full sm:w-auto">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="canceled" {{ request('status') === 'canceled' ? 'selected' : '' }}>Canceled</option>
            </select>
            <input type="date" name="date" value="{{ request('date') }}" class="bg-white/50 border-white/50 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm backdrop-blur-sm w-full sm:w-auto">
            <button type="submit" class="bg-gray-800/90 hover:bg-gray-900 text-white px-4 py-2 rounded-lg shadow text-sm font-semibold backdrop-blur-sm w-full sm:w-auto">Filter</button>
            @if(request()->hasAny(['status', 'date']))
                <a href="{{ route('dashboard') }}" class="text-sm text-indigo-800 font-semibold hover:underline mt-2 sm:mt-0">Clear</a>
            @endif
        </form>
    </div>
    
    <div class="p-0">
        @if($appointments->isEmpty())
            <div class="p-8 text-center text-gray-600 font-medium">
                No appointments found matching your criteria.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/30">
                    <thead class="bg-white/40 backdrop-blur-sm border-b border-white/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Patient</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date & Time</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/30">
                        @foreach($appointments as $appointment)
                            <tr class="hover:bg-white/20 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $appointment->patient->first_name }} {{ $appointment->patient->name }}</div>
                                    <div class="text-sm text-gray-600">{{ $appointment->patient->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                                    <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full shadow-sm border border-white/50 backdrop-blur-sm
                                        {{ $appointment->status === 'accepted' ? 'bg-green-100/80 text-green-800' : '' }}
                                        {{ $appointment->status === 'pending' ? 'bg-yellow-100/80 text-yellow-800' : '' }}
                                        {{ $appointment->status === 'completed' ? 'bg-blue-100/80 text-blue-800' : '' }}
                                        {{ $appointment->status === 'canceled' ? 'bg-red-100/80 text-red-800' : '' }}
                                    ">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        @if($appointment->status === 'pending')
                                            <form method="POST" action="{{ route('appointments.updateStatus', $appointment) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="accepted">
                                                <button type="submit" class="text-green-800 hover:text-green-900 font-bold bg-green-100/80 px-3 py-1 rounded-md shadow-sm border border-green-200/50 backdrop-blur-sm transition">Accept</button>
                                            </form>
                                            <form method="POST" action="{{ route('appointments.updateStatus', $appointment) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="canceled">
                                                <button type="submit" class="text-red-800 hover:text-red-900 font-bold bg-red-100/80 px-3 py-1 rounded-md shadow-sm border border-red-200/50 backdrop-blur-sm transition">Decline</button>
                                            </form>
                                        @elseif($appointment->status === 'accepted')
                                            <form method="POST" action="{{ route('appointments.updateStatus', $appointment) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="text-blue-800 hover:text-blue-900 font-bold bg-blue-100/80 px-3 py-1 rounded-md shadow-sm border border-blue-200/50 backdrop-blur-sm transition">Mark Completed</button>
                                            </form>
                                        @endif
                                        
                                        @if($appointment->status === 'accepted' || $appointment->status === 'completed')
                                            <a href="{{ route('messages.show', $appointment->patient) }}" class="text-indigo-800 hover:text-indigo-900 font-bold bg-indigo-100/80 px-3 py-1 rounded-md shadow-sm border border-indigo-200/50 backdrop-blur-sm transition">Message</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Consultation Notes Section for Completed Appointments -->
                            @if($appointment->status === 'completed')
                            <tr class="bg-white/30 border-b border-white/50 backdrop-blur-sm">
                                <td colspan="4" class="px-6 py-4">
                                    <form method="POST" action="{{ route('appointments.updateNotes', $appointment) }}" class="flex flex-col gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Consultation Notes (Private)</label>
                                        <div class="flex flex-col sm:flex-row gap-2">
                                            <textarea name="consultation_notes" rows="2" class="flex-1 bg-white/50 border-white/50 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm backdrop-blur-sm" placeholder="Add private notes regarding this consultation...">{{ $appointment->consultation_notes }}</textarea>
                                            <button type="submit" class="w-full sm:w-auto sm:self-end bg-gray-800/90 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded-lg shadow-sm text-sm backdrop-blur-sm transition">
                                                Save Notes
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endif
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
