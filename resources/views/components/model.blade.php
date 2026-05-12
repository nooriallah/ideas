<div 
    x-data="{ modelOpen: true}" 
    x-show="modelOpen" 
    @open-model.window="if($event.detail === 'create-model') modelOpen = true" 
    @close-model.window="modelOpen = false"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">

    <x-Idea.card class="w-1/2">
        {{ $slot }}
    </x-Idea.card>

</div>
