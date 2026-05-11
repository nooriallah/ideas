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
            {{-- Making a model for adding ideas by alpinejs --}}
            <button x-data 
            type="button" class="btn" 
            @click="$dispatch('open-model', 'create-model');">
                Add Idea
            </button>
        </div>

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



    {{-- Add Idea Model --}}
    <div x-data="{ modelOpen: false}" 
    x-show="modelOpen" 
    @open-model.window="if($event.detail === 'create-model') modelOpen = true" 
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">

        <div class="bg-white p-6 rounded shadow-lg w-1/3" @click.away="modelOpen = false">
            <h2 class="text-xl mb-4">Add New Idea</h2>
            <form action="{{ route('idea.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" @click="modelOpen = false" class="btn btn-outline-dark mr-2">Cancel</button>
                    <button type="submit" class="btn">Submit</button>
                </div>
            </form>
        </div>

    </div>


</x-layout>
