@props([
    'type' => 'text',
    'name',
    'id',
    'label',
    'disabled' => false,
    'valid' => '',
    'value',
])

@php
    $disabledClass = $disabled ? " bg-gray-50 dark:bg-gray-400 " : " dark:bg-gray-600 ";
@endphp

@error($name ?? $id)
    @php($valid = ' ring-red-500 dark:ring-red-500')
@enderror

<label for="{{ $id ?? $name ?? $label }}"
       class='block mb-2 font-medium text-sm text-gray-800 dark:text-gray-100'
>
    {{ $label ?? $name ?? $id }}
</label>

@if($disabled)
    <div class="
        ring-1
        p-2.5 w-full block border rounded-lg sm:leading-6
        bg-gray-50 dark:bg-gray-400
        border-gray-300 dark:border-gray-400
        text-gray-900 dark:text-gray-100
        focus:ring-teal-600 dark:focus:ring-teal-500
        focus:border-teal-600 dark:focus:border-teal-500
        placeholder-gray-300 dark:placeholder-gray-300
    ">
        {{ $value ?? '' }}
    </div>
@else
    <input id="{{ $id ?? $name ?? $label }}"
           {{ $disabled ? 'disabled' : '' }}
           {!! $attributes->merge(['class' => "
        p-2.5 ml-0.5 w-full block rounded-lg
        ring-1 border-2
        border-gray-300 dark:border-gray-500
        text-gray-900 dark:text-gray-100
        focus:ring-2 dark:focus:ring-2
        focus:ring-teal-600 dark:focus:ring-teal-500
        focus:border-teal-600 dark:focus:border-teal-500
        placeholder-gray-300 dark:placeholder-gray-300
        {$disabledClass} {$valid}
    "]) !!}
           name="{{ $name ?? $id }}"
           value="{{ $value ?? '' }}"
    >

    @error($name ?? $id)
        <span class="dark:text-red-500">{{ $message }}</span>
    @endif
@endif
