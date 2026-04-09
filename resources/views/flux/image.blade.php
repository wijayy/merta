@props(['image' => null, 'aspect' => 'square'])

@php
    $imageUrl = '';
    if (!empty($image)) {
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            $imageUrl = $image;
        } else {
            $path = public_path('storage/' . $image);
            $imageUrl = file_exists($path) ? asset('storage/' . $image) : '';
        }
    }
@endphp

<div class="bg-cover bg-center bg-no-repeat aspect-{{ $aspect }} rounded-t-lg"
    style="background-image: url('{{ $imageUrl }}') "></div>
