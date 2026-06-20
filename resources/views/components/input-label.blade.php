@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-malba-gray-dark']) }}>
    {{ $value ?? $slot }}
</label>
