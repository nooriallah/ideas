@props(["title", 'subtitle'])

<div class="flex min-h-[calc(100vh-4rem)] items-center justify-center px-4">
    <div class="w-full max-w-md">
        
        <div class="text-center">
            <h1 class="text-3xl tracking-tight font-bold">{{ $title }}</h1>
            <p class="text-muted-foreground">{{ $subtitle }}</p>
        </div>


        {{ $slot }}


    </div>
</div>
