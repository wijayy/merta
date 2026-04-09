@props(['button' => false, 'projectList' => []])

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 ">
    @foreach ($projectList as $item)
        <div class="border border-mine-300 rounded-lg h-full flex flex-col">
            <flux:image image="{{ $item->image }}" aspect="video" />
            <div class="p-4 flex flex-col justify-between">
                <div class="">
                    <flux:text size="xl" variant="strong" class=" font-semibold">{{ $item->title }}</flux:text>
                    <flux:text >{{ $item->description }}</flux:text>
                </div>

                @if($button)
                <div class="flex justify-center gap-2 mt-4">
                    <flux:button size="sm" href="{{ $item->url }}" icon="eye" color="blue"
                        variant="primary"></flux:button>
                    <flux:button size="sm" icon="pencil-square" wire:click="editModal({{ $item->id }})"
                        color="yellow" variant="primary">
                    </flux:button>
                    <flux:button size="sm" icon="trash" color="rose" variant="primary"
                        wire:click="openDeleteModal({{ $item->id }})"></flux:button>
                </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
