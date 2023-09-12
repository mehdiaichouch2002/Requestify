@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-teal-500 focus:ring-indigo-500 rounded-full shadow-sm','type'=>'date']) !!}>
