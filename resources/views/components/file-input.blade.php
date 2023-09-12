@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 mt-3 focus:border-teal-500 focus:ring-indigo-500 shadow-sm','type'=>'file']) !!}>
