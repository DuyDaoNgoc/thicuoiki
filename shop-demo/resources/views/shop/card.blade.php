{{-- resources/views/components/nav-link.blade.php --}}
<a {{ $attributes->merge(['class' => 'text-sm font-medium text-gray-700']) }}>
    {{ $slot }}
</a>
