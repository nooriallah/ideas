<x-layout>


    <div class="flex justify-between my-20">
        <a href="{{ route("idea.index") }}" class="btn">
            {{-- Here is a svg icon on component > icons > arrow-left --}}
            <x-icons.left-arrow />
            Back to all ideas
        </a>

        <div class="flex gap-x-2">
            <button class="flex btn btn-edit">
                <x-icons.external />Edit</button>
            <form action="{{ route('idea.destroy', $idea) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this idea?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete">Delete</button>
            </form>
        </div>
    </div>


    <div class="flex flex-col gap-6">
        <x-idea.card is="div" class="w-full">
            <h1 class="text-2xl">{{ $idea->title }}</h1>
            <p class="font-medium mb-10">{{ $idea->description }}</p>

            <div class="flex align-center gap-4">
                <x-idea.idea-status :status="$idea->status->value">{{ $idea->status->label() }}</x-idea.idea-status>
                <p class="text-sm">{{ $idea->created_at->diffForHumans() }}</p>
            </div>

            {{-- check if there is any links then show them inside of card --}}
        @if (collect($idea->links)->isNotEmpty())
        <h2 class="text-xl mt-10">Related Links</h2>
        <div class=" flex flex-col">
            @foreach ($idea->links as $link)
            <a href="{{ $link }}" class="text-blue-500 underline" target="_blank"> {{ $link }} </a>
            @endforeach
        </div>
        @endif

        @if ($idea->steps->isNotEmpty())
        <h2 class="text-xl mt-10">Steps</h2>
        <div class="flex flex-col gap-2">
            @foreach ($idea->steps as $step)
            <form action="{{ route('step.update', $step) }}" method="POST" class="flex items-center gap-2">
                @csrf
                @method('PATCH')
                {{-- <input type="checkbox" id="steps-{{ $step->id }}" class="" onchange="this.form.submit()" @checked($step->completed)> --}}
                <button type="submit" class="btn {{ !$step->completed ? 'btn-outlined' : '' }}">&check;</button>
                <label for="steps-{{ $step->id }}" class="{{ $step->completed ? 'line-through text-gray-400' : '' }}">{{ $step->description }}</label>
            </form>
            @endforeach
        </div>
        @endif

        </x-idea.card>


        
    </div>

</x-layout>
