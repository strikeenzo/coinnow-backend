<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;

trait CustomFileTrait
{

    public function createDirectory($path)
    {
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
    }

    public function saveCustomFileAndGetImageName($image, $path)
    {

        $newImageName = time() . $image->getClientOriginalName();
        $image->move($path, $newImageName);
        return $newImageName;
    }

    public function removeOldImage($image, $path)
    {
        if ($image) {
            $oldImage = $path . '/' . $image;
            if (File::exists($oldImage)) {
                //unlink($oldImage);
            }
        }

    }

    public function changeDateFormat($date, $fromFormat, $toFormat)
    {
        return Carbon::createFromFormat($fromFormat, $date)->format($toFormat);
    }
}
