<!-- alert.blade.php -->

@props(['type' => 'success', 'message' => ''])

@php
    $alertClasses = [
        'success' => 'alert alert-success py-2 px-4',
        'danger' => 'alert alert-danger py-2 px-4',
    ];

    $textClasses = [
        'success' => 'text-green-800 dark:text-green-400',
        'danger' => 'text-red-800 dark:text-red-400',
    ];

    $bgClasses = [
        'success' => 'bg-green-50 dark:bg-gray-800',
        'danger' => 'bg-red-50 dark:bg-gray-800',
    ];
@endphp

<div class="{{ $alertClasses[$type] }}">
    <div class="p-4 mb-4 text-sm {{ $textClasses[$type] }} rounded-lg {{ $bgClasses[$type] }}" role="alert">
        <span class="font-medium">{{ $message }}</span>
    </div>
</div>
