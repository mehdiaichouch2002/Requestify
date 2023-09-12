<button {{ $attributes->merge(['type' => 'submit', 'class' => 'focus:outline-none text-black font-light bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg mt-2 text-sm px-7 py-1 dark:bg-my-light-red dark:hover:bg-red-600 dark:focus:ring-red-900']) }}>
    {{ $slot }}
</button>
