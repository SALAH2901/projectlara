<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-indigo-900 leading-tight">
            {{ __('Book Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <!-- Doctor Profile Info -->
            <div class="w-full md:w-1/3">
                <div class="bg-white/60 backdrop-blur-lg border border-white/50 shadow-xl rounded-2xl overflow-hidden">
                    <div class="p-6">
                        <div class="text-center mb-6">
                            @if($doctor->profile_photo_path)
                                <img src="{{ Storage::url($doctor->profile_photo_path) }}" alt="{{ $doctor->name }}" class="h-32 w-32 rounded-full object-cover mx-auto mb-4 border-4 border-white/80 shadow-md">
                            @else
                                <div class="h-32 w-32 rounded-full bg-indigo-100/80 backdrop-blur-sm mx-auto flex items-center justify-center text-indigo-800 text-4xl font-bold mb-4 border-4 border-white/80 shadow-md">
                                    {{ substr($doctor->first_name, 0, 1) }}{{ substr($doctor->name, 0, 1) }}
                                </div>
                            @endif
                            <h3 class="text-2xl font-bold text-gray-900">Dr. {{ $doctor->first_name }} {{ $doctor->name }}</h3>
                            <p class="text-indigo-800 font-bold mt-1">{{ $doctor->doctorProfile->specialization ?? 'General Practice' }}</p>
                            
                            @php
                                $avgRating = $doctor->reviewsReceived()->avg('rating') ?? 0;
                                $reviewCount = $doctor->reviewsReceived()->count();
                            @endphp
                            <div class="mt-3 flex items-center justify-center gap-1 bg-white/50 inline-flex px-3 py-1 rounded-full border border-white/50 shadow-sm backdrop-blur-sm">
                                <svg class="w-5 h-5 {{ $avgRating >= 1 ? 'text-yellow-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <span class="text-gray-900 font-bold">{{ number_format($avgRating, 1) }}</span>
                                <span class="text-gray-600 text-sm">({{ $reviewCount }} reviews)</span>
                            </div>
                        </div>
                        
                        <div class="border-t border-white/50 pt-4 mt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-700 font-bold">Consultation Fee</span>
                                <span class="font-bold text-indigo-900 bg-white/50 px-2 py-1 rounded-lg border border-white/50 backdrop-blur-sm">${{ number_format($doctor->doctorProfile->consultation_fee ?? 0, 2) }}</span>
                            </div>
                        </div>
                        
                        <div class="border-t border-white/50 pt-4 mt-4">
                            <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Biography</h4>
                            <p class="text-gray-700 text-sm leading-relaxed">
                                {{ $doctor->doctorProfile->biography ?? 'No biography available.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="w-full md:w-2/3">
                <div class="bg-white/60 backdrop-blur-lg border border-white/50 shadow-xl rounded-2xl overflow-hidden">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-indigo-900 mb-6">Request an Appointment</h3>
                        
                        <form method="POST" action="{{ route('appointments.store') }}">
                            @csrf
                            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                            @if(isset($unavailabilities) && $unavailabilities->isNotEmpty())
                                <div class="mb-6 p-4 bg-orange-50/80 border border-orange-200 rounded-xl backdrop-blur-sm shadow-sm">
                                    <h4 class="font-bold text-orange-800 mb-2 text-sm flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Doctor Unavailable Dates
                                    </h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($unavailabilities as $unavail)
                                            <span class="text-xs font-semibold bg-orange-100 text-orange-800 px-2 py-1 rounded-md border border-orange-200">
                                                {{ $unavail->start_date->format('M d') }} 
                                                @if($unavail->start_date != $unavail->end_date)
                                                    - {{ $unavail->end_date->format('M d') }}
                                                @endif
                                            </span>
                                        @endforeach
                                    </div>
                                    <p class="text-xs text-orange-700 mt-2 italic">Please select a date outside of these blocked periods.</p>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <x-input-label for="appointment_date" :value="__('Preferred Date')" class="font-bold text-gray-800" />
                                    <x-text-input id="appointment_date" class="block mt-1 w-full bg-white/50 border-white/50 backdrop-blur-sm" type="date" name="appointment_date" :value="old('appointment_date')" required min="{{ date('Y-m-d') }}" />
                                    <x-input-error :messages="$errors->get('appointment_date')" class="mt-2" />
                                </div>
                                
                                <div>
                                    <x-input-label for="appointment_time" :value="__('Preferred Time')" class="font-bold text-gray-800" />
                                    <x-text-input id="appointment_time" class="block mt-1 w-full bg-white/50 border-white/50 backdrop-blur-sm" type="time" name="appointment_time" :value="old('appointment_time')" required />
                                    <x-input-error :messages="$errors->get('appointment_time')" class="mt-2" />
                                </div>
                            </div>

                            <div class="mb-8">
                                <x-input-label for="consultation_notes" :value="__('Reason for Visit / Notes (Optional)')" class="font-bold text-gray-800" />
                                <textarea id="consultation_notes" name="consultation_notes" rows="4" class="block mt-1 w-full bg-white/50 border-white/50 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm backdrop-blur-sm">{{ old('consultation_notes') }}</textarea>
                                <x-input-error :messages="$errors->get('consultation_notes')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end">
                                <button type="submit" class="inline-flex justify-center items-center px-6 py-3 bg-indigo-600/90 backdrop-blur-sm border border-transparent rounded-xl font-bold text-sm text-white tracking-widest hover:bg-indigo-700 shadow-lg transition duration-150 transform hover:-translate-y-0.5">
                                    {{ __('Request Appointment') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Patient Reviews Section -->
                <div class="bg-white/60 backdrop-blur-lg border border-white/50 shadow-xl rounded-2xl mt-6 overflow-hidden">
                    <div class="p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 border-b border-white/50 pb-4">Patient Reviews</h3>
                        @php
                            $reviews = $doctor->reviewsReceived()->with('patient')->latest()->get();
                        @endphp

                        @if($reviews->isEmpty())
                            <p class="text-gray-600 italic bg-white/40 p-4 rounded-xl border border-white/50">No reviews yet for this doctor.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($reviews as $review)
                                    <div class="bg-white/40 backdrop-blur-sm p-4 rounded-xl border border-white/50 shadow-sm transition hover:bg-white/50">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-bold text-gray-900">{{ $review->patient->first_name }} {{ substr($review->patient->name, 0, 1) }}.</span>
                                            <span class="text-xs font-bold text-gray-600 bg-white/50 px-2 py-1 rounded-md">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex items-center mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-400/50' }}" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            @endfor
                                        </div>
                                        @if($review->comment)
                                            <p class="text-gray-800 text-sm mt-2">{{ $review->comment }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
