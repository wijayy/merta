<?php

use Livewire\Component;
use App\Models\Project;
use Livewire\Attributes\On;

new class extends Component {
    public $title = 'Projects';
    public $projectList;
    public $selectedProject;
    public function mount()
    {
        $this->projectList = $this->getProjectList();
    }

    public function openDeleteModal($id)
    {
        $this->selectedProject = Project::find($id);
        $this->dispatch('modal-show', name: 'delete-project');
    }

    public function deleteProject()
    {
        if ($this->selectedProject) {
            $this->selectedProject->delete();
            $this->projectList = $this->getProjectList(); // Refresh the project list
            $this->closeModal();
            session()->flash('success', 'Data berhasil dihapus.');
        }
    }

    public function getProjectList()
    {
        return Project::all();
    }

    #[On('project-saved')]
    public function refreshProjectList()
    {
        $this->projectList = $this->getProjectList();
    }

    public function createModal()
    {
        $this->dispatch('createModal');
    }

    public function editModal($id)
    {
        $this->dispatch('editModal', $id);
    }

    public function closeModal()
    {
        $this->dispatch('modal-close', name: 'delete-project');
    }
};
?>

@section('title', $title)

<div class="space-y-4">
    <flux:sidebar-header>{{ $title }}

        <x-slot name="button">
            <flux:button  variant="primary" size="sm" wire:click="createModal">Create Project
            </flux:button>
        </x-slot>
    </flux:sidebar-header>
    <flux:sidebar-content>

        <flux:project-index :projectList="$projectList" :button="true"></flux:project-index>
        <flux:modal name="delete-project">
            <div>
                <p>Are you sure you want to delete this project {{ $selectedProject?->title }}?</p>
            </div>
            <div class="mt-4 flex justify-end gap-2">
                <flux:button color="gray" size="sm" wire:click="closeModal" variant="primary">Cancel
                </flux:button>
                <flux:button color="rose" size="sm" variant="primary" wire:click="deleteProject">Delete
                </flux:button>
            </div>
        </flux:modal>
    </flux:sidebar-content>
    @livewire('project-create')
</div>
