@props([
    'activeTemplate' => null,
])

@include('templates.options', ['activeTemplate' => $activeTemplate])
