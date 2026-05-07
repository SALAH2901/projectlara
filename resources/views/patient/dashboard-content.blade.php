<div class="bg-white/60 backdrop-blur-lg border border-white/50 shadow-xl sm:rounded-2xl mb-6 overflow-hidden">
    <div class="p-6 border-b border-white/50 flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left">
        <div>
            <h3 class="text-2xl font-bold text-indigo-900 mb-2">Hello, {{ auth()->user()->first_name }}!</h3>
            <p class="text-gray-700">Welcome to your patient dashboard.</p>
        </div>
        <div>
            <a href="{{ route('doctors.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600/90 backdrop-blur-sm border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                Find a Doctor
            </a>
        </div>
    </div>
</div>

<div class="bg-white/60 backdrop-blur-lg border border-white/50 shadow-xl sm:rounded-2xl overflow-hidden">
    <div class="p-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-4">
            <h4 class="text-xl font-semibold text-gray-800">Your Appointments</h4>
            <a href="{{ route('export.patient.history') }}" class="inline-flex items-center px-4 py-2 bg-white/50 border border-indigo-200 rounded-lg font-semibold text-xs text-indigo-700 uppercase tracking-widest hover:bg-indigo-50 transition ease-in-out duration-150 shadow-sm backdrop-blur-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export History (PDF)
            </a>
        </div>
        @if($appointments->isEmpty())
            <div class="p-4 bg-gray-50 rounded-lg text-center text-gray-500">
                You have no appointments booked yet.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/30">
                    <thead class="bg-white/40 backdrop-blur-sm border-b border-white/50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Doctor</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date & Time</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/30">
                        @foreach($appointments as $appointment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($appointment->doctor->profile_photo_path)
                                            <img src="{{ Storage::url($appointment->doctor->profile_photo_path) }}" alt="{{ $appointment->doctor->name }}" class="h-10 w-10 rounded-full object-cover border border-gray-200 mr-3">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm border border-indigo-200 mr-3">
                                                {{ substr($appointment->doctor->first_name, 0, 1) }}{{ substr($appointment->doctor->last_name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Dr. {{ $appointment->doctor->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $appointment->doctor->doctorProfile->specialization ?? 'General' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $appointment->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $appointment->status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $appointment->status === 'canceled' ? 'bg-red-100 text-red-800' : '' }}
                                    ">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        @if($appointment->status === 'pending' || $appointment->status === 'accepted')
                                            <form method="POST" action="{{ route('appointments.updateStatus', $appointment) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="canceled">
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold bg-red-50 px-3 py-1 rounded border border-red-200" onclick="return confirm('Are you sure you want to cancel this appointment?')">Cancel</button>
                                            </form>
                                        @endif
                                        @if($appointment->status === 'accepted' || $appointment->status === 'completed')
                                            <a href="{{ route('messages.show', $appointment->doctor) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold bg-indigo-50 px-3 py-1 rounded border border-indigo-200">Message</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @if($appointment->status === 'completed' && !$appointment->review)
                            <tr class="bg-white/40 border-b border-white/50 backdrop-blur-sm">
                                <td colspan="4" class="px-6 py-4">
                                    <form method="POST" action="{{ route('reviews.store', $appointment) }}" class="flex flex-col sm:flex-row items-stretch sm:items-start gap-4">
                                        @csrf
                                        <div class="flex-1 flex flex-col sm:flex-row gap-2">
                                            <select name="rating" required class="bg-white/50 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm backdrop-blur-sm sm:w-auto">
                                                <option value="">Rate this doctor</option>
                                                <option value="5">5 Stars - Excellent</option>
                                                <option value="4">4 Stars - Good</option>
                                                <option value="3">3 Stars - Average</option>
                                                <option value="2">2 Stars - Poor</option>
                                                <option value="1">1 Star - Terrible</option>
                                            </select>
                                            <input type="text" name="comment" placeholder="Leave a brief comment (optional)" class="bg-white/50 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm flex-1 w-full backdrop-blur-sm">
                                        </div>
                                        <button type="submit" class="bg-indigo-600/90 backdrop-blur-sm hover:bg-indigo-700 text-white font-semibold py-2 px-4 border border-transparent rounded shadow-sm text-sm whitespace-nowrap">
                                            Submit Review
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @elseif($appointment->status === 'completed' && $appointment->review)
                            <tr class="bg-yellow-100/50 border-b border-white/50 backdrop-blur-sm">
                                <td colspan="4" class="px-6 py-3 text-sm text-yellow-800">
                                    <span class="font-semibold">Your Review:</span> {{ $appointment->review->rating }} Stars. "{{ $appointment->review->comment }}"
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
