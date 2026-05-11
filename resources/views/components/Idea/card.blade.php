@props(["is" => "a"])

<{{ $is }} {{ $attributes(["class"=> "card bg-card p-10 rounded mt-5 space-y-4"]) }} >
    {{ $slot }}
</{{ $is }}>
