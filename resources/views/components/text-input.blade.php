@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white/50 border-white/50 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm backdrop-blur-sm transition duration-150']) }}>
