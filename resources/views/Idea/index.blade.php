<x-layout>

    <h1 class="text-2xl mt-10">All Ideas here!</h1>

    {{-- Making filter buttons and showing status counts --}}
    <div class="flex gap-4 mt-20">
        <a href="{{ route('idea.index') }}" class="rounded py-2 px-4 btn-outline-dark border {{ !$status ? 'bg-gray-700' : '' }}">
            All ({{ $statusCounts['all'] }})</a>

        @foreach (\App\IdeaStatus::cases() as $stat)
        <a href="{{ route('idea.index', ['status' => $stat->value]) }}" class="rounded p-2 btn-outline-dark border {{ $status === $stat->value ? 'bg-gray-700' : '' }}">
            {{ $stat->label() }} ({{ $statusCounts[$stat->value] }})</a>
        @endforeach

        <div class="flex flex-end ml-auto">
            {{-- Making a button event handler for adding ideas by alpinejs --}}
            <button x-data type="button" class="btn" @click="$dispatch('open-model', 'create-model');">
                Add Idea
            </button>
        </div>

    </div>


    {{-- Showing all ideas here --}}
    <div class="grid grid-cols-2 gap-6 mt-5">
        @forelse ($ideas as $idea)
        <x-idea.card href="{{ route('idea.show', $idea) }}" class="space-y-5">
            @if ($idea->image_path)
            <div class="flex rounded-lg overflow-hidden -mx-10 -mt-10">
                <img src="{{ asset('storage/frontend/images/ideas/' . $idea->image_path) }}" alt="Idea image">
            </div>
            @endif
            <h2 class="text-2xl">{{ $idea->title }}</h2>
            <p class="font-medium">{{ $idea->description }}</p>
            <x-idea.idea-status :status="$idea->status->value">{{ $idea->status->label() }}</x-idea.idea-status>
            <p class="text-sm mt-5">{{ $idea->created_at->diffForHumans() }}</p>
        </x-idea.card>
        @empty
        <h2>No ideas found.</h2>
        @endforelse

    </div>



    {{-- Add Idea Model --}}
    <x-model />


</x-layout>
