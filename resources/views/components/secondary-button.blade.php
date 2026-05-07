<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 bg-white/70 backdrop-blur-sm border border-white/80 rounded-xl font-bold text-sm text-gray-800 uppercase tracking-widest shadow hover:bg-white/90 disabled:opacity-25 transition duration-150 transform hover:-translate-y-0.5']) }}>
    {{ $slot }}
</button>
