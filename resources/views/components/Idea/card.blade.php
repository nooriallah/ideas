@props(["is" => "a"])

<{{ $is }} {{ $attributes(["class"=> "card bg-card p-10 rounded-lg mt-5 space-y-4"]) }} >
    {{ $slot }}
</{{ $is }}>
