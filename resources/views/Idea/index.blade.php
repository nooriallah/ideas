<x-layout>

    <h1 class="text-2xl mt-10">All Ideas here!</h1>

    {{-- Making filter buttons and showing status counts --}}
    <div class="flex gap-4 mt-20">
        <a href="{{ route('idea.index') }}"
             class="rounded py-2 px-4 btn-outline-dark border {{ !$status ? 'bg-gray-700' : '' }}">
             All ({{ $statusCounts['all'] }})</a>
        @foreach (\App\IdeaStatus::cases() as $stat)
        
        <a href="{{ route('idea.index', ['status' => $stat->value]) }}"
             class="rounded p-2 btn-outline-dark border {{ $status === $stat->value ? 'bg-gray-700' : '' }}">
             {{ $stat->label() }} ({{ $statusCounts[$stat->value] }})</a>
        @endforeach
    </div>

    <div class="grid grid-cols-2 gap-6 mt-5">

        @forelse ($ideas as $idea)
        <x-idea.card href="{{ route('idea.show', $idea) }}">
            <h2 class="text-2xl">{{ $idea->title }}</h2>
            <p class="font-medium">{{ $idea->description }}</p>
            <x-idea.idea-status :status="$idea->status->value">{{ $idea->status->label() }}</x-idea.idea-status>
        </x-idea.card>
        @empty
        <h2>No ideas found.</h2>
        @endforelse

    </div>

</x-layout>
