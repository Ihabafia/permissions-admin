@props([
    'class',
    'color' => 'teal',
    'type' => 'button'
])

<button
    type="{{ $type }}"
    {{ $attributes }}
    {{ $attributes->merge(['class' => "
        font-medium text-center
        text-sm px-5 py-2 ml-3
        rounded-lg border-2
        focus:ring-2
        focus:outline-none
        ark:border-{$color}-500
        text-{$color}-500
        hover:text-gray-100
        border-{$color}-500
        hover:border-{$color}-300
        hover:bg-{$color}-600
        focus:ring-{$color}-300
    "]) }}
>
    {{ $slot }}
</button>
