<?php
/**
 * Created by PhpStorm.
 * User: Vitaly
 * Date: 24.05.2018
 * Time: 0:30
 */

namespace ProfPlatforma\Orders\Services;

use ProfPlatforma\Orders\Models\Image;

class ImageService
{
    public function create($values)
    {
        $image = new Image($values);
        $image->save();
        return $image->id;
    }

    public function delete(Image $image)
    {
        try {
            return $image->delete();
        } catch (\Exception $e) {
        }
    }
}