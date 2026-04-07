<?php

namespace App\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesImageUploads
{
    protected function storeResizedImage(UploadedFile $image, string $folder, int $maxWidth = 500): string
    {
        if (! function_exists('imagecreatefromstring')) {
            return $image->store($folder, 'public');
        }

        $mime = $image->getMimeType();
        $path = $image->getRealPath();

        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $src = imagecreatefromjpeg($path);
                $extension = 'jpg';
                break;
            case 'image/png':
                $src = imagecreatefrompng($path);
                $extension = 'png';
                break;
            case 'image/webp':
                $src = imagecreatefromwebp($path);
                $extension = 'webp';
                break;
            case 'image/gif':
                $src = imagecreatefromgif($path);
                $extension = 'gif';
                break;
            default:
                return $image->store($folder, 'public');
        }

        if (! $src) {
            return $image->store($folder, 'public');
        }

        $width = imagesx($src);
        $height = imagesy($src);

        if ($width <= $maxWidth) {
            $target = $src;
            $newWidth = $width;
            $newHeight = $height;
        } else {
            $newWidth = $maxWidth;
            $newHeight = (int) round($height * ($maxWidth / $width));
            $target = imagecreatetruecolor($newWidth, $newHeight);

            if (in_array($mime, ['image/png', 'image/webp', 'image/gif'], true)) {
                imagealphablending($target, false);
                imagesavealpha($target, true);
                $transparent = imagecolorallocatealpha($target, 0, 0, 0, 127);
                imagefilledrectangle($target, 0, 0, $newWidth, $newHeight, $transparent);
            }

            imagecopyresampled($target, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        }

        $filename = Str::uuid()->toString().'.'.$extension;
        Storage::disk('public')->makeDirectory($folder);
        $storagePath = Storage::disk('public')->path($folder.'/'.$filename);

        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                imagejpeg($target, $storagePath, 80);
                break;
            case 'image/png':
                imagepng($target, $storagePath, 8);
                break;
            case 'image/webp':
                imagewebp($target, $storagePath, 80);
                break;
            case 'image/gif':
                imagegif($target, $storagePath);
                break;
        }

        if ($target !== $src) {
            imagedestroy($target);
        }

        imagedestroy($src);

        return $folder.'/'.$filename;
    }
}
