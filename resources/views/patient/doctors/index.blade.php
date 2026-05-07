<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-indigo-900 leading-tight">
            {{ __('Find a Doctor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Search Bar -->
            <div class="bg-white/60 backdrop-blur-lg border border-white/50 shadow-xl sm:rounded-2xl mb-8 overflow-hidden">
                <div class="p-6">
                    <form action="{{ route('doctors.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or specialization..." class="flex-1 bg-white/50 border-white/50 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm backdrop-blur-sm">
                        <button type="submit" class="inline-flex justify-center items-center px-6 py-3 bg-indigo-600/90 backdrop-blur-sm border border-transparent rounded-xl font-bold text-sm text-white tracking-widest hover:bg-indigo-700 shadow-md transition">
                            Search
                        </button>
                    </form>
                </div>
            </div>

            <!-- Doctors Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($doctors as $doctor)
                    <div class="bg-white/60 backdrop-blur-md border border-white/50 shadow-lg rounded-2xl overflow-hidden flex flex-col transition hover:-translate-y-1 hover:shadow-xl duration-300">
                        <div class="p-6 flex-1 flex gap-4">
                            @if($doctor->profile_photo_path)
                                <img src="{{ Storage::url($doctor->profile_photo_path) }}" alt="{{ $doctor->name }}" class="h-16 w-16 rounded-full object-cover border border-white/80 shadow-sm shrink-0">
                            @else
                                <div class="h-16 w-16 rounded-full bg-indigo-100/80 backdrop-blur-sm flex items-center justify-center text-indigo-800 font-bold text-xl border border-white/80 shadow-sm shrink-0">
                                    {{ substr($doctor->first_name, 0, 1) }}{{ substr($doctor->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Dr. {{ $doctor->name }}</h3>
                                    <span class="bg-indigo-100/80 backdrop-blur-sm text-indigo-900 border border-white/50 shadow-sm text-xs px-2 py-1 rounded-full font-bold">
                                        ${{ number_format($doctor->doctorProfile->consultation_fee ?? 0, 2) }}
                                    </span>
                                </div>
                                <p class="text-indigo-700 font-bold mb-2">{{ $doctor->doctorProfile->specialization ?? 'General Practice' }}</p>
                                <p class="text-gray-700 text-sm line-clamp-3">
                                    {{ $doctor->doctorProfile->biography ?? 'No biography available.' }}
                                </p>
                            </div>
                        </div>
                        <div class="bg-white/40 p-4 border-t border-white/50 mt-auto backdrop-blur-sm">
                            <a href="{{ route('doctors.show', $doctor) }}" class="w-full text-center block px-4 py-2.5 bg-white/70 backdrop-blur-sm border border-white/80 rounded-xl font-bold text-sm text-gray-800 tracking-widest shadow hover:bg-white/90 transition">
                                View Profile & Book
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white/60 backdrop-blur-md border border-white/50 p-8 rounded-2xl shadow-lg text-center text-gray-700 font-medium">
                        No doctors found matching your criteria.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $doctors->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
