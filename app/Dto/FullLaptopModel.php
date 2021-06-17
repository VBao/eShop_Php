<?php


namespace App\Dto;


use App\Models\Product\Image;
use App\Models\Product\Laptop\laptopSpec;
use App\Models\Product\productInfo;

class FullLaptopModel
{
    public productInfo $info;
    public laptopSpec $spec;
    public Image $image;

    /**
     * test constructor.
     */
    public function __construct($id)
    {
        $this->info = productInfo::query()->where('id', $id)->get()->first();
        $this->spec = laptopSpec::query()->where('id', $id)->get()->first();
        $this->image = Image::query()->where('info_id', $id)->get()->first();
    }

}
