<?php 

namespace App\Managers;

use Illuminate\Support\Facades\Storage;

/**
 * Image Handling Abstracton
 */
class PublicImageManager
{

    public function putFile($img, string $name): string 
    {
        $imgExtension = $img->getClientOriginalExtension();
        $fileName = "{$name}.{$imgExtension}";
        
        Storage::disk('public')->putFileAs('images', $img, $fileName);

        return $fileName; 
    }

    public function deleteFile(string $name) 
    {
        return Storage::disk('public')->delete("images/{$name}");
    }
}