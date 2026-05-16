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
    <x-model>
        <h2 class="text-2xl mb-4">Add New Idea</h2>
        <form
        x-data="{
            status: 'pending',
            newLink: '',
            links: []
        }" 
        method="post" action="{{ route('idea.store') }}">
            @csrf
        

            <fieldset x-data class="mb-3">
                <legend>Links</legend>
                <div class="flex gap-3">
                    <input type="url" x-model="newLink" placeholder="Enter a link..." class="input">
                    <button type="button" @click="links.push(newLink); newLink = '';" class="btn">+</button>
                </div>

                <pre x-text="newLink"></pre>

                <template x-for="(link, index) in links" :key="index">
                    <div class="flex items-center gap-2 mt-2">
                        {{-- <a :href="link" target="_blank" class="text-blue-500 underline" x-text="link"></a> --}}
                        <input type="text" name="links[]" :value="link" readonly class="input">
                        <button type="button" @click="links.splice(index, 1)" class="btn btn-outlined">X</button>
                    </div>
                </template>

            </fieldset>


            <x-form.field name="title" label="Title" placeholder="Idea title..." />

            <div class="mb-4 space-y-3">
                <label for="status" class="form-label block">Status</label>
                @foreach (\App\IdeaStatus::cases() as $status)
                <button type="button" @click="status = '{{ $status->value }}'" :class="status === '{{ $status->value }}' ? 'btn' : 'btn btn-outlined'">
                    {{ $status->label() }}
                </button>
                @endforeach
                <input type="hidden" name="status" :value="status">
            </div>

            <x-form.field name="description" label="Description" type="textarea" placeholder="Idea description..." />

            <button type="submit" class="btn">Submit</button>
            <button type="button" class="btn btn-outlined" @click="$dispatch('close-model')">Cancel</button>
        </form>
    </x-model>


</x-layout>
