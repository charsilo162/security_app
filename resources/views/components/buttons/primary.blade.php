<button {{ $attributes->merge([
    'class' => 'bg-red-600 hover:bg-red-700 px-6 py-3 rounded-full font-semibold transition'
]) }}>
    {{ $slot }}
</button>
