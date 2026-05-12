@props(["label" => null, "name", "type" => "text", "placeholder" => ""])

<div class="mb-5 space-y-2">
    @if($label)
    <label for="{{ $name }}" class="label">{{ $label }}</label>
    @endif

    @if($type === "textarea")
    <textarea id="{{ $name }}" name="{{ $name }}" class="input" class="textarea" placeholder="{{ $placeholder }}" style="min-height: 150px;">{{ old($name) }}</textarea>
    @elseif($type === "select")
    <select id="{{ $name }}" name="{{ $name }}" class="input">
        {{ $slot }}
    </select>
    @else
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}" class="input" placeholder="{{ $placeholder }}">
    @endif

    @error($name)
    <span class="text-red-400">{{ $message }}</span>
    @enderror
</div>
