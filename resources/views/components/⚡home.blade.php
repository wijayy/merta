<?php

use Livewire\Component;

new class extends Component {
    public $title = 'Home';
    public $useHeader = false;
};
?>


<div class="">
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="useHeader">
        {{ $useHeader }}
    </x-slot>

    <h1 class="text-4xl font-bold mb-4">Welcome to Merta</h1>
    <p class="text-lg text-gray-600">This is the home page of your Merta application. Use the navigation to explore the features.</p>
</div>
