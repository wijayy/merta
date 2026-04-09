<?php

use App\Concerns\HandlesImageUploads;
use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;
    use HandlesImageUploads;

    public $selectedProject;

    public $old_image;

    protected array $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'image' => 'nullable|image',
        'url' => 'required|url',
    ];

    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('required|string|max:255')]
    public $description = '';

    #[Validate('nullable|image')]
    public $image;

    public $tempImagePath;

    #[Validate('required|url')]
    public $url = '';

    #[On('createModal')]
    public function openCreateModal()
    {
        $this->title = '';
        $this->description = '';
        $this->url = '';
        $this->old_image = null;
        $this->dispatch('modal-show', name: 'create-project');
    }

    #[On('editModal')]
    public function openEditModal($id)
    {
        $project = Project::find($id);
        if ($project) {
            $this->selectedProject = $project;
            $this->title = $project->title;
            $this->description = $project->description;
            $this->url = $project->url;
            $this->old_image = $project->image;
            $this->dispatch('modal-show', name: 'create-project');
        }
    }

    public function saveProject()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->storeResizedImage($this->image, 'projects');
        }

        Project::updateOrCreate(
            ['id' => $this->selectedProject?->id],
            [
                'title' => $this->title,
                'description' => $this->description,
                'url' => $this->url,
                'image' => $imagePath ?? $this->old_image,
            ],
        );

        $this->reset(['title', 'description', 'url', 'image', 'selectedProject', 'old_image']);
        $this->dispatch('modal-close', name: 'create-project');
        $this->dispatch('project-saved');
    }
};
?>

<div>
    <flux:modal name="create-project" title="Create Project">
        <form wire:submit.prevent="saveProject">

            <div class="space-y-4">
                <!-- Image Upload with Preview -->
                <div class="space-y-2">
                    <flux:input label="Project Image" type="file" aspect="video" wire:model.live="image"
                        preview="{{ asset('storage/' . $old_image) }}" accept="image/*"></flux:input>
                </div>

                <flux:input label="Title" wire:model.live="title" required></flux:input>
                <flux:input label="URL" wire:model.live="url" required></flux:input>
                <flux:textarea label="Description" wire:model.live="description" required></flux:textarea>
            </div>
            <div class="flex justify-center mt-4" name="footer">
                <flux:button type="submit" color="primary">Save</flux:button>
            </div>
        </form>

    </flux:modal>
</div>
