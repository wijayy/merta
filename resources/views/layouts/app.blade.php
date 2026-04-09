{{-- @dd($useHeader ?? 0, $title ?? 'No title', $layout ?? 'No layout', $slot ?? 'No slot') --}}

@php
    $useHeader = isset($useHeader) ? $useHeader : false;
@endphp

@if ($useHeader)
    <x-layouts::app.header :title="$title ?? null">
        <flux:main >
            {{ $slot }}
        </flux:main>
    </x-layouts::app.header>
@else
    <x-layouts::app.sidebar :title="$title ?? null">
        <flux:main>
            {{ $slot }}
        </flux:main>
    </x-layouts::app.sidebar>
@endif
