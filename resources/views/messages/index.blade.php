<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-indigo-900 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/60 backdrop-blur-lg border border-white/50 shadow-xl sm:rounded-2xl overflow-hidden">
                <div class="p-8">
                    <h3 class="text-2xl font-bold mb-6 border-b border-white/50 pb-4 text-indigo-900">Your Conversations</h3>
                    
                    @if($conversations->isEmpty())
                        <div class="text-center text-gray-700 font-medium py-12 bg-white/40 rounded-xl border border-white/50">
                            You have no messages yet.
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($conversations as $user)
                                <a href="{{ route('messages.show', $user) }}" class="block p-4 border border-white/50 rounded-xl hover:bg-white/60 bg-white/40 backdrop-blur-sm transition ease-in-out duration-150 flex items-center justify-between group shadow-sm hover:shadow-md">
                                    <div class="flex items-center gap-4">
                                        @if($user->profile_photo_path)
                                            <img src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}" class="h-14 w-14 rounded-full object-cover border-2 border-white shadow-sm shrink-0">
                                        @else
                                            <div class="h-14 w-14 rounded-full bg-indigo-100/80 backdrop-blur-sm flex items-center justify-center text-indigo-700 font-bold text-xl border border-white/80 shadow-sm shrink-0">
                                                {{ substr($user->first_name, 0, 1) }}{{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900 group-hover:text-indigo-700 transition-colors">
                                                {{ $user->role === 'doctor' ? 'Dr. ' : '' }}{{ $user->first_name }} {{ $user->name }}
                                            </h4>
                                            <p class="text-sm font-semibold text-gray-600 capitalize">{{ $user->role }}</p>
                                        </div>
                                    </div>
                                    <div class="text-indigo-600 group-hover:translate-x-1 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
