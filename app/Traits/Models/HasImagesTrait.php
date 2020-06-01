<?php

namespace App\Traits\Models;

use Gumlet\ImageResize;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasImagesTrait
{
    /**
     * Delete all image in storage
     * Use when updating or deleting product.
     *
     * @version 1.0.0
     */
    public function deleteImages()
    {
        foreach ($this->getImageArray() as $image) {
            if ($image) {
                $imagePath = storage_path("app/public/uploads/{$this->getTable()}/{$this->id}/images/{$image}");
                hsp_debug([
                    'recycle_product_id' => $this->id,
                    'unlink_image_path' => $imagePath,
                ]);
                unlink($imagePath);
            }
        }
    }

    /**
     * Clear product folder in the system
     * Use when destroying product resources.
     *
     * @version 1.3.0
     */
    public function clearImageFolder()
    {
        $this->deleteImages();
        rmdir(storage_path("app/public/uploads/{$this->getTable()}/{$this->id}/images"));
        rmdir(storage_path("app/public/uploads/{$this->getTable()}/{$this->id}"));
    }

    /**
     * Save images from temp to public folder.
     *
     * @version 1.1.0
     */
    public function saveImages(Request $request, $imageField)
    {
        foreach (range(1, static::TOTAL_IMAGES) as $index) {
            $imageAttribute = "image{$index}";
            $this->$imageAttribute = '';
        }

        foreach ($request->input($imageField) as $index => $imagePath) {
            if (file_exists($imagePath)) {
                $temporaryFile = new File($imagePath);
                $image = 'image'.($index + 1);
                $filePath = "public/uploads/{$this->getTable()}/{$this->id}/images";
                $imagePath = Storage::putFile($filePath, $temporaryFile);
                // get file name in returned path
                $this->$image = basename($imagePath);
            }
        }
    }

    /**
     * Get images from form upload field, then save to /tmp folder
     * return a resized version of image as base64 string and path in tmp folder.
     *
     * @version 1.1.0
     */
    public function prepareImageForConfirm(Request $request, string $imageField)
    {
        $confirmImages = [];
        $total = static::TOTAL_IMAGES - 1;
        if ($request->hasFile($imageField)) {
            foreach ($request->images as $index => $image) {
                $imagePath = Str::finish(config('filesystems.disks.temp.root'), '/').$image->store('/recycle-product-admin', 'temp');
                $base64String = cache()->remember(md5_file($imagePath), 600, function () use ($imagePath) {
                    $croppedImage = new ImageResize($imagePath);
                    $croppedImage->resizeToHeight(400);

                    return base64_encode($croppedImage->getImageAsString());
                });

                $confirmImages[] = (object) [
                    'path' => $imagePath,
                    'base64String' => $base64String,
                ];

                if ($index === $total) {
                    // limit to $totalImages
                    break;
                }
            }
        }

        return $confirmImages;
    }

    /**
     * Return asset url of image.
     *
     * @version 1.0.0
     */
    public function getImageAsset($image)
    {
        if (blank($image)) {
            return '';
        }

        return asset("storage/uploads/{$this->getTable()}/{$this->id}/images/{$image}");
    }

    /**
     * Preload images from range 1 to TOTAL_IMAGES and, format it with assets return array.
     *
     * @version 1.2.0
     */
    public function getImageAssetsArray(bool $trimEmpty = true)
    {
        $imageArray = [];
        foreach (range(1, static::TOTAL_IMAGES) as $index) {
            $imageAttribute = "image{$index}";
            if ($trimEmpty && blank($this->$imageAttribute)) {
                continue;
            }
            $imageArray[$imageAttribute] = $this->getImageAsset($this->$imageAttribute);
        }

        return $imageArray;
    }

    /**
     * Preload images from range 1 to TOTAL_IMAGES.
     *
     * @version 1.0.0
     */
    public function getImageArray()
    {
        $imageArray = [];
        foreach (range(1, static::TOTAL_IMAGES) as $index) {
            $imageAttribute = "image{$index}";
            $imageArray[$imageAttribute] = $this->$imageAttribute;
        }

        return $imageArray;
    }
}
