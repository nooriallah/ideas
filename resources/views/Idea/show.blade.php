<x-layout>


    <div class="flex justify-between my-20">
        <a href="{{ route("idea.index") }}" class="btn">
            {{-- Here is a svg icon on component > icons > arrow-left --}}
            <x-icons.left-arrow />
            Back to all ideas
        </a>

        <div class="flex gap-x-2">
            <button class="flex btn btn-edit"><x-icons.external />Edit</button>
            <form action="{{ route('idea.destroy', $idea) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this idea?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete">Delete</button>
            </form>
        </div>
    </div>


    <div class="flex">
        <x-idea.card>
        <h1 class="text-2xl">{{ $idea->title }}</h1>
        <p class="font-medium">{{ $idea->description }}</p> 
        <x-idea.idea-status :status="$idea->status->value" >{{ $idea->status->label() }}</x-idea.idea-status>       
    </x-idea.card>
    </div>
    
</x-layout>