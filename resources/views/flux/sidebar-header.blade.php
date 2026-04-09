<div class="rounded py-2 px-4 bg-white dark:bg-neutral-700 flex justify-between">
    <div class="">

        <div class="text-lg font-semibold">{{ $slot }}</div>
        @if (session('success'))
            <div class="text-green-400 mt-1">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="text-rose-500 mt-1">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <div class="">{{ $button ?? false }}</div>
</div>
