<?php

use Livewire\Component;

new class extends Component {
    public $title = 'Home';
    public $useHeader = false;

    public $projectList;

    public function mount()
    {
        $this->projectList = $this->getProjectList();
    }

    public function getProjectList()
    {
        return \App\Models\Project::latest()->take(6)->get();
    }
};
?>

<div class="">
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="useHeader">
        {{ $useHeader }}
    </x-slot>

    <flux:container>

        <h1 class="text-4xl font-bold mb-4">Welcome to Merta</h1>
        <p class="text-lg text-gray-600">This is the home page of your Merta application. Use the navigation to explore
            the
            features.</p>

        <div class="min-h-svh flex flex-col justify-center items-center">
            <div>
                <flux:text variant="strong" class=" font-semibold" size="3xl">Latest Projects</flux:text>
            </div>
            <div class=" mt-2">
                <flux:project-index :projectList="$projectList"></flux:project-index>
            </div>
        </div>
    </flux:container>

    @livewire('footer')
</div>
