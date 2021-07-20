<?php


namespace App\Service\Impl;

use App\Dto\FullLaptopModel;
use App\Dto\Info\postInfoDto;
use App\Dto\Info\showImage;
use App\Dto\Info\showInfoDto;
use App\Http\Resources\BrandIndexResource;
use App\Http\Resources\DriveListResource;
use App\Http\Resources\ListLaptopResource;
use App\Http\Resources\ShowListResource;
use App\Models\Cart;
use App\Models\Product\Brand;
use App\Models\Product\Image;
use App\Models\Product\Laptop\Cpu;
use App\Models\Product\Laptop\Ram;
use App\Models\Product\Laptop\Rom;
use App\Models\Product\productInfo;
use App\Models\Product\Type;
use App\Service\ILaptopService;
use App\Service\IProductService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations\Info;

class ProductImpl implements IProductService
{
    protected productInfo $info;
    protected Brand $brand;
    protected Type $type;
    protected Ram $ram;
    protected Rom $rom;
    protected Cpu $cpu;
    protected Image $image;
    protected ILaptopService $laptopService;

    /**
     * ProductImpl constructor.
     * @param productInfo $info
     * @param Brand $brand
     * @param Type $type
     * @param Ram $ram
     * @param Rom $rom
     * @param Cpu $cpu
     * @param Image $image
     * @param ILaptopService $laptopService
     */
    public function __construct(productInfo $info, Brand $brand, Type $type, Ram $ram, Rom $rom, Cpu $cpu, Image $image, ILaptopService $laptopService)
    {
        $this->info = $info;
        $this->brand = $brand;
        $this->type = $type;
        $this->ram = $ram;
        $this->rom = $rom;
        $this->cpu = $cpu;
        $this->image = $image;
        $this->laptopService = $laptopService;
    }


    public function getInfos()
    {
        // TODO: Implement getInfos() method.
    }
    public function getIndex()
    {
    }

    public function create(postInfoDto $info): productInfo
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

    public function createImages($images, $id): array
    {
        $res = [];
        foreach ($images as $image) {
            $img = new Image;
            $img->link_image = $image;
            $img->info_id = $id;
            $img->save();
            $temp = [];
            $temp['link'] = $image;
            $temp['id'] = $id;
            $res[] = $temp;
        }
        return $res;
    }

    public function getById($id): showInfoDto
    {
        $response = new showInfoDto();
        $info = $this->info->newQuery()->where('id', $id)->first();
        $response->id = $info->id;
        $response->name = $info->name;
        $response->price = $info->price;
        $response->guarantee = $info->guarantee;
        $response->brand_id = $info->brand_id;
        $response->type_id = $info->type_id;
        $response->description = $info->description;
        $response->created_at = $info->created_at;
        $response->updated_at = $info->updated_at;;
        return $response;
    }


    public function getImages($id): array
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


    public function putImage($images, $id)
    {
        foreach ($images as $key => $value) {
            $oldImage = Image::query()->where('id', $key)->first();
            $oldImage->link_image = $value;
            $oldImage->save();
        }
        return Image::query()->where('info_id', $id)->get();
    }

    public function putInfo($newInfo)
    {
        $oldInfo = $this->info->getById($newInfo->id);
        foreach ($newInfo as $key => $value) {
            $oldInfo->$key = $value;
        }
        $oldInfo->updated_at = date('Y-m-d H:i:s');
        $oldInfo->save();
        return $oldInfo;
    }

    public function getByType($id)
    {
        return $this->info->where('type_id', $id)->orderByDesc('id')->get('id');
    }

    public function searchByType($keyword)
    {
        // TODO: Implement searchByType() method.
    }

    public function searchByBrand($keyword)
    {
        // TODO: Implement searchByBrand() method.
    }

    public function brandIndex()
    {
        $rs['brand'] = BrandIndexResource::collection(Brand::all());
        $temp = [];
        foreach (productInfo::query()->where('created_at', '>', now()->subMonth())->orderBy('created_at', 'desc')->limit(8)->get() as $product) {
            if ($product->type_id == 1) {
                $temp[] = new ListLaptopResource($product);
            } elseif ($product->type_id == 2) {
                $temp[] = new DriveListResource($product);
            }
            $rs['new'] = ['id' => 1, 'title' => 'New product', 'result' => $temp];
        }
        $temp = [];
        foreach (Cart::query()->select('product_id', \DB::raw('sum(quantity) as TotalQty'))->groupBy('product_id')->limit(8)->get() as $product) {
            $product = productInfo::query()->where('id', '=', $product->product_id)->first();
            if ($product->type_id == 1) {
                $temp[] = new ListLaptopResource($product);
            } elseif ($product->type_id == 2) {
                $temp[] = new DriveListResource($product);
            }
            $rs['top'] = ['id' => 1, 'title' => 'Best sell', 'result' => $temp];
        }
        return $rs;
    }
}
