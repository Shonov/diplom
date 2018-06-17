<?php

namespace ProfPlatforma\Orders\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ProfPlatforma\Orders\Models\Image;
use Intervention\Image\Facades\Image as ImageInt;
use ProfPlatforma\Orders\Services\ImageService;

class ImageController extends Controller
{
    private $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function create(Request $request)
    {
        return [
            'id' => $this->imageService->create($request),
        ];
    }

    public function delete(Image $image)
    {
        return [
            'status' => $this->imageService->delete($image),
        ];
    }
}
