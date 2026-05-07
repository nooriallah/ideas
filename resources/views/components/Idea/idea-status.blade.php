@props(["status"=> "pending"])
@php

    $classes = "badge text-white p-1 rounded ";
    $classes .= match ($status) {
        "completed" => "bg-green-500",
        "inprogress" => "bg-yellow-500",
        "pending" => "bg-red-500",
        default => "bg-gray-500",
    }
@endphp
<span {{ $attributes(["class" => $classes]) }}>
    {{ $slot }}
</span>