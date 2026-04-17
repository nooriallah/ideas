@props(["title", "name", "type" => "text"])

<div class="mb-5 space-y-2">
    <label for="{{ $name }}" class="label">{{ $title }}</label>
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}" class="input">
    @error($name)
    <span class="text-red-400">{{ $message }}</span>
    @enderror
</div>
