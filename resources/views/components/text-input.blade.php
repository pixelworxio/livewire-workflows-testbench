@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'dark:bg-white/10 dark:focus:bg-black/50 border-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-pink-500 focus:ring-indigo-500 dark:focus:ring-pink-500 rounded-md shadow-sm']) }}>
