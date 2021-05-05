<?php


namespace App\Service\Impl;

use App\Dto\Info\postInfoDto;
use App\Dto\Info\showImage;
use App\Dto\Info\showInfoDto;
use App\Dto\Laptop\detailLaptopDto;
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
    protected productInfo $info;
    protected Brand $brand;
    protected Type $type;
    protected Image $image;
    protected ILaptopService $laptopService;

    /**
     * ProductImpl constructor.
     * @param productInfo $info
     * @param Brand $brand
     * @param Type $type
     */
    public function __construct(productInfo $info, Brand $brand, Type $type, Image $image, ILaptopService $laptopService)
    {
        $this->info = $info;
        $this->brand = $brand;
        $this->type = $type;
        $this->image = $image;
        $this->laptopService = $laptopService;

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
            foreach ($this->info->getIndex($item->id) as $info) {
                $product = new indexProductDto();
                $product->id = $info->id;
                $product->name = $info->name;
                $product->price = $info->price;
                $productSpecs = $this->laptopService->getSpecsIndex($info->id);
                $product->ram = explode(",", $productSpecs['ram'])[0];
                $product->rom = explode(',', $productSpecs['rom'])[0];
                $temp = $this->image->newQuery()->where('info_id', $info->id)->first();
                if ($temp != null) $product->image = $temp['link_image'];
//                $img=   $this->image->newQuery()->where('info_id', $info->id)->first();
//                $product->image =  $img->link_image;
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
        $createInfo->description = $info->description;
        $createInfo->guarantee = $info->guarantee;
        $createInfo->price = $info->price;
        $createInfo->brand_id = $info->brand_id;
        $createInfo->type_id = $info->type_id;
        $createInfo->created_at = date('Y-m-d H:i:s');
        $createInfo->save();
        $createInfo->refresh();
        return $createInfo;
    }

    public function createImages($images, $id)
    {
        $res = [];
        foreach ($images as $key => $image) {
            $img = new Image;
            $img->link_image = $image;
            $img->info_id = $id;
            $img->save();
            $res[] = $img;
        }
    }

    public function getById($id)
    {
        $response = new showInfoDto();
        $info = $this->info->newQuery()->where('id', $id)->first();
        $response->id=$info->id;
        $response->name=$info->name;
        $response->price=$info->price;
        $response->guarantee=$info->guarantee;
        $brand_id=$info->brand_id;
        $response->brand=Brand::query()->where('id',$brand_id)->first()->brand;
        $response->description=$info->description;
        return $response;
    }


    public function getImages($id)
    {
        $res = [];
        foreach ($this->image->getById($id) as $val) {
            $img = new showImage();
            $img->id = $val->id;
            $img->img = $val->link_image;
            $res[] = $img;
        }
        return $res;
    }


    public function putImage($images,$id)
    {
        foreach ($images as $key=>$value){
            $oldImage=Image::query()->where('id',$key)->first();
            $oldImage->link_image=$value;
            $oldImage->save();
        }
        return Image::query()->where('info_id',$id)->get();
    }

    public function putInfo($newInfo)
    {
        $oldInfo = $this->info->getById($newInfo->id);
        foreach ($newInfo as $key => $value) {
            $oldInfo->$key=$value;
        }
        $oldInfo->updated_at=date('Y-m-d H:i:s');
        $oldInfo->save();
        return $oldInfo;
    }

    public function getByType($id)
    {
        return $this->info->where('type_id',$id)->get('id');
    }
}
