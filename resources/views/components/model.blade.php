@props(['idea' => null])
<div x-data="{ modelOpen: false }" x-show="modelOpen" @open-model.window="if($event.detail === '{{ $idea ? 'edit-model' : 'create-model' }}') modelOpen = true" @close-model.window="modelOpen = false" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">

    <x-Idea.card class="w-1/2">

        <h2 class="text-2xl mb-4">{{ $idea ? 'Edit Idea' : 'Add New Idea' }}</h2>
        <form x-data="{
            status: @js($idea?->status?->value ?? 'pending'),
            newLink: '',
            links: @js($idea?->links ?? []),
            newStep: '',
            steps: @js($idea ? $idea->steps->map(fn ($step) => ['id' => $step->id, 'description' => $step->description])->values() : []),
        }" enctype="multipart/form-data" method="post" action="{{ $idea ? route('idea.update', $idea) : route('idea.store') }}">
            @csrf
            @if ($idea)
            @method('PUT')
            @endif


            <x-form.field type="file" name="image" label="Image" placeholder="Upload an image..." />

            <x-form.field name="title" label="Title" placeholder="Idea title..." value="{{ $idea->title ?? '' }}" />

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
                    <input type="url" x-model="newLink" placeholder="https://example.com" class="input">
                    <button type="button" @click="if (newLink) { links.push(newLink); newLink = ''; }" class="btn">+</button>
                </div>
                <template x-for="(link, index) in links" :key="index">
                    <div class="flex items-center gap-2 mt-2">
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
                    <button type="button" @click="if (newStep) { steps.push({ id: null, description: newStep }); newStep = ''; }" class="btn">+</button>
                </div>
                <template x-for="(step, index) in steps" :key="index">
                    <div class="flex items-center gap-2 mt-2">
                        <input type="hidden" :name="'steps[' + index + '][id]'" :value="step.id">
                        <input type="text" :name="'steps[' + index + '][description]'" :value="step.description" class="input" readonly required>
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

            <x-form.field name="description" label="Description" type="textarea" placeholder="Idea description..." value="{{ $idea->description ?? '' }}" />

            <button type="submit" class="btn">{{ $idea ? 'Update' : 'Submit' }}</button>
            <button type="button" class="btn btn-outlined" @click="$dispatch('close-model')">Cancel</button>
        </form>
    </x-Idea.card>

</div>
