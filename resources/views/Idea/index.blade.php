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
                <img src='{{ asset("storage/$idea->image_path") ?? "storage/placeholder.png" }}' alt="Idea image">
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
    {{-- now on model there is a form check if form is submited and show the error if there is any error for form fields then don't close the form model --}}

    <x-model>
        <h2 class="text-2xl mb-4">Add New Idea</h2>
        <form x-data="{
            status: 'pending',
            newLink: '',
            links: [],
            newStep: '',
            steps: [],
        }" enctype="multipart/form-data" method="post" action="{{ route('idea.store') }}">
            @csrf

            <x-form.field type="file" name="image" label="Image" placeholder="Upload an image..." />

            <x-form.field name="title" label="Title" placeholder="Idea title..." />

            <div class="mb-4 space-y-3">
                <label for="status" class="form-label block">Status</label>
                @foreach (\App\IdeaStatus::cases() as $status)
                <button type="button" @click="status = '{{ $status->value }}'" :class="status === '{{ $status->value }}' ? 'btn' : 'btn btn-outlined'">
                    {{ $status->label() }}
                </button>
                @endforeach
                <input type="hidden" name="status" :value="status">
                @error("status")
                <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <fieldset class="mb-3">
                <legend class="mb-3">Links</legend>
                <div class="flex gap-3">
                    <input type="url" x-model="newLink" placeholder="www.example.com" class="input">
                    <button type="button" @click="if (newLink) { links.push(newLink); newLink = ''; }" class="btn">+</button>
                </div>
                <template x-for="(link, index) in links" :key="index">
                    <div class="flex items-center gap-2 mt-2">
                        {{-- <a :href="link" target="_blank" class="text-blue-500 underline" x-text="link"></a> --}}
                        {{-- On value check if it dosn't has https:// then add it before link --}}
                        <input type="url" name="links[]" :value="link" class="input" readonly required>
                        <button type="button" @click="links.splice(index, 1)" class="btn btn-outlined">x</button>
                    </div>

                </template>

                {{-- show its error here if there is any error for links --}}
                @error("links")
                <span class="text-red-400">{{ $message }}</span>
                @enderror

                @error("links.*")
                <span class="text-red-400">{{ $message }}</span>
                @enderror

            </fieldset>


            <fieldset class="mb-3">
                <legend class="mb-3">Steps</legend>
                <div class="flex gap-3">
                    <input type="text" x-model="newStep" placeholder="Add a step..." class="input">
                    <button type="button" @click="if (newStep) { steps.push(newStep); newStep = ''; }" class="btn">+</button>
                </div>
                <template x-for="(step, index) in steps" :key="index">
                    <div class="flex items-center gap-2 mt-2">
                        <input type="text" name="steps[]" :value="step" class="input" readonly required>
                        <button type="button" @click="steps.splice(index, 1)" class="btn btn-outlined">x</button>
                    </div>

                </template>

                @error("steps")
                <span class="text-red-400">{{ $message }}</span>
                @enderror

                @error("steps.*")
                <span class="text-red-400">{{ $message }}</span>
                @enderror

            </fieldset>

            <x-form.field name="description" label="Description" type="textarea" placeholder="Idea description..." />

            <button type="submit" class="btn">Submit</button>
            <button type="button" class="btn btn-outlined" @click="$dispatch('close-model')">Cancel</button>
        </form>
    </x-model>


</x-layout>
