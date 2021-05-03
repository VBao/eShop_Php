<?php


namespace App\Service\Impl;

use App\Dto\Info\postInfoDto;
use App\Dto\Laptop\indexProductDto;
use App\Dto\Laptop\productInfoGetList;
use App\Models\Product\Brand;
use App\Models\Product\Image;
use App\Models\Product\Laptop\laptopSpec;
use App\Models\Product\productInfo;
use App\Service\ILaptopService;
use App\Service\IProductService;
use App\Models\Product\Type;

class ProductImpl implements IProductService
{
    protected productInfo $productInfo;
    protected Brand $brand;
    protected Type $type;
    protected Image $image;
    protected ILaptopService $laptopService;

    /**
     * ProductImpl constructor.
     * @param productInfo $productInfo
     * @param Brand $brand
     * @param Type $type
     */
    public function __construct(productInfo $productInfo, Brand $brand, Type $type, Image $image, ILaptopService $laptopService)
    {
        $this->productInfo = $productInfo;
        $this->brand = $brand;
        $this->type = $type;
        $this->image = $image;
        $this->laptopService = $laptopService;

    }

    public function getInfosFull(): array
    {
        $arrInfos = [];
        foreach ($this->productInfo->all()->makeHidden(['brand_id', 'type_id']) as $product) {
            $productDto = new productInfoGetList();
            $productDto->info = $product;
            $productDto->brand = $this->brand->where('id', $product->brand_id)->first();
            $productDto->type = $this->type->where('id', $product->type_id)->first();
            $arrInfos[] = $productDto;
        }
        return $arrInfos;
    }

    public function getInfos()
    {
        // TODO: Implement getInfos() method.
    }

    public function getIndex(int $type = 0, int $brand = 0)
    {
        if ($type == 0)
            $res = array();
        foreach ($this->brand->all() as $item) {
            $index = new productInfoGetList;
            $index->id = $item->id;
            $index->brand = $item->brand;
            foreach ($this->productInfo->getIndex($item->id) as $info) {
                $product = new indexProductDto();
                $product->id = $info->id;
                $product->name = $info->name;
                $product->price = $info->price;
                $productSpecs = $this->laptopService->getSpecsIndex($info->id);
                $product->ram = $productSpecs['ram'];
                $product->rom = $productSpecs['rom'];
                $product->image = $this->image->newQuery()->where('info_id', $info->id)->first()->link_image;
                $index->infos[] = $product;
            }
            $res[] = $index;
        }
        return $res;
    }


    public function create(postInfoDto $info)
    {
        $createInfo = new productInfo;
//        foreach ($createInfo as $key => $value) {
//            $createInfo->$key = $value;
//        }
        $createInfo->name = $info->name;
        $createInfo->description=$info->description;
        $createInfo->guarantee=$info->guarantee;
        $createInfo->price=$info->price;
        $createInfo->brand_id=$info->brand;
        $createInfo->type_id=$info->type;
        $createInfo->created_at=date('Y-m-d H:i:s');
        $createInfo->save();
        $createInfo->refresh();
        return $createInfo;
    }
}
