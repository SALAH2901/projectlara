<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-indigo-600/90 backdrop-blur-sm border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 shadow-lg transition duration-150 transform hover:-translate-y-0.5']) }}>
    {{ $slot }}
</button>
