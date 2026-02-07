@props(['label'])

<div>
    <label class="block mb-1 text-sm font-medium
                   text-gray-700 dark:text-gray-300">
        {{ $label }}
    </label>

    <textarea {{ $attributes->merge([
        'class' => 'block w-full rounded-md border-gray-300
                    dark:border-gray-600
                    bg-white dark:bg-gray-800
                    text-gray-900 dark:text-gray-100
                    focus:border-indigo-500 focus:ring-indigo-500'
    ]) }}>{{ $slot }}</textarea>
</div>
