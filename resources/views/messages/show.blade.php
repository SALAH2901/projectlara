<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('messages.index') }}" class="text-indigo-800 hover:text-indigo-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            @if($user->profile_photo_path)
                <img src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}" class="h-10 w-10 rounded-full object-cover border border-white/80 shadow-sm">
            @else
                <div class="h-10 w-10 rounded-full bg-indigo-100/80 backdrop-blur-sm flex items-center justify-center text-indigo-800 font-bold text-sm border border-white/80 shadow-sm">
                    {{ substr($user->first_name, 0, 1) }}{{ substr($user->name, 0, 1) }}
                </div>
            @endif
            <h2 class="font-bold text-xl text-indigo-900 leading-tight">
                {{ $user->role === 'doctor' ? 'Dr. ' : '' }}{{ $user->first_name }} {{ $user->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/60 backdrop-blur-lg border border-white/50 shadow-xl rounded-2xl flex flex-col h-[600px] overflow-hidden">
                
                <!-- Messages Area -->
                <div class="flex-1 p-6 overflow-y-auto bg-white/30 backdrop-blur-sm space-y-4 flex flex-col scrollbar-thin scrollbar-thumb-white/50 scrollbar-track-transparent">
                    @forelse($messages as $msg)
                        <div class="max-w-[75%] rounded-2xl px-5 py-3 shadow-md backdrop-blur-sm {{ $msg->sender_id === auth()->id() ? 'bg-indigo-600/90 text-white self-end rounded-br-sm border border-indigo-500/50' : 'bg-white/70 text-gray-900 self-start rounded-bl-sm border border-white/80' }}">
                            <p class="text-sm whitespace-pre-wrap">{{ $msg->message }}</p>
                            <span class="text-xs mt-1 block {{ $msg->sender_id === auth()->id() ? 'text-indigo-200' : 'text-gray-500' }} font-medium">
                                {{ $msg->created_at->format('M d, h:i A') }}
                                @if($msg->sender_id === auth()->id() && $msg->read_at)
                                    • Read
                                @endif
                            </span>
                        </div>
                    @empty
                        <div class="text-center text-gray-700 font-medium my-auto bg-white/40 p-6 rounded-2xl border border-white/50 shadow-sm mx-10">
                            No messages yet. Send a message to start the conversation!
                        </div>
                    @endforelse
                </div>

                <!-- Input Area -->
                <div class="p-4 bg-white/50 border-t border-white/50 backdrop-blur-md">
                    <form action="{{ route('messages.store', $user) }}" method="POST" class="flex gap-3">
                        @csrf
                        <input type="text" name="message" placeholder="Type your message..." required class="flex-1 bg-white/60 border-white/50 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm backdrop-blur-sm px-4">
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-2 bg-indigo-600/90 backdrop-blur-sm border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 shadow-md transition transform hover:-translate-y-0.5">
                            Send
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
