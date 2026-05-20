<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ideas</title>

    @vite(["resources/css/app.css", "resources/js/app.js"])

</head>
<body class="bg-background text-foreground">


    <x-layout.header />


    <main class="max-w-7xl mx-auto px-6 ">
        {{ $slot }}
    </main>


    {{-- Showing flash success message on bottom left for 3 second with alpinejs --}}
    @if (session("success"))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
        x-transition.opacity.duration.500ms 
        class="absolute bottom-1 right-4 bg-green-500 text-white px-4 py-2 rounded">
        {{-- Success message --}}
        {{ session("success") }}
    </div>
    @endif
</body>
</html>
