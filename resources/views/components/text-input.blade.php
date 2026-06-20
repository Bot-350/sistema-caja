@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-malba-gray-lighter focus:border-malba-rose-pale focus:ring-2 focus:ring-malba-rose-pale/20 rounded-lg shadow-elegant transition-all duration-200']) }}>
