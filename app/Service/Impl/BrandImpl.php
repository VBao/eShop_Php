<?php
namespace App\Service\Impl;
use App\Models\Product\Brand;
use App\Service\IBrandService;

class BrandImpl implements IBrandService{

    protected Brand $brand;
    public function __construct(Brand $brand)
    {
        $this->brand=$brand;
    }

    public function getBrand(int $id): Brand
    {
        return $this->brand->where('id',$id)->first();
    }

}
