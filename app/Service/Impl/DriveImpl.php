<?php


namespace App\Service\Impl;


use App\Http\Resources\DriveDetailsResource;
use App\Http\Resources\DriveListResource;
use App\Http\Resources\LaptopIndexResource;
use App\Models\Product\Brand;
use App\Models\Product\Drive\DriveCache;
use App\Models\Product\Drive\DriveCapacity;
use App\Models\Product\Drive\DriveConnect;
use App\Models\Product\Drive\DriveDimension;
use App\Models\Product\Drive\DriveRead;
use App\Models\Product\Drive\DriveRotation;
use App\Models\Product\Drive\DriveSpecs;
use App\Models\Product\Drive\DriveType;
use App\Models\Product\Drive\DriveWrite;
use App\Models\Product\productInfo;
use App\Service\IDriveService;
use Illuminate\Support\Collection;

class DriveImpl implements IDriveService
{

    public function getForm()
    {
        return [
            'info' => ['brands' => Brand::query()->where('type_id', 2)->get(['id', 'brand'])],
            'spec' => ['capacities' => DriveCapacity::all(),
                'caches' => DriveCache::all(),
                'connections' => DriveConnect::all(),
                'writes' => DriveWrite::all(),
                'reads' => DriveRead::all(),
                'dimensions' => DriveDimension::all(),
                'rotations' => DriveRotation::all(),
                'types' => DriveType::all(),]

        ];
    }

    public function create($drive, $id)
    {
        $createDrive = new DriveSpecs;
        $createDrive->id = $id;
        foreach ($drive as $property => $value) {
            if ($property == 'drive_type_id') {
                $createDrive->type_id = $value;
            } else {
                $createDrive->$property = $value;
            }
        }
        $createDrive->save();
//        if (!$createDrive->save()) throw new Exception();
        return $createDrive;
    }

    public function update($drive)
    {
        $createDrive = DriveSpecs::query()->where('id', $drive->id)->first();
        foreach ($drive as $property => $value) {
            $createDrive->$property = $value;
        }
        $createDrive->save();
        return $createDrive;
    }


    public function get($id)
    {
        $res = [];
//        $info=[];
//        $info[] = new InfoResource(productInfo::find($id));
        $info = new DriveDetailsResource(DriveSpecs::find($id));
//        $res['info']=$info;
//        $res['description']=$info[0]['description'];
//        $res['images']=ImageResource::collection(Image::where('info_id',$id)->get());
        return $info;
    }

    public function list()
    {
//        foreach (Brand::where('type_id','=',2)->get() as $brand){
//
//        }
        return DriveListResource::collection(productInfo::where('type_id', 2)->get());
    }

    public function filter(array $filter)
    {
        $list_drive = new Collection();
        foreach ($filter['brand'] as $brand) {
            foreach
            (productInfo::where('brand_id', $brand)->whereBetween('price', [$filter['min_price'], $filter['max_price']])->get()
             as $info) {
                $drive_spec = DriveSpecs::find($info->id);
                if (in_array($drive_spec->capacity_id, $filter['capacity']) || in_array($drive_spec->connect_id, $filter['connect']))
                    $list_drive->add($info);
            }
        }
        return DriveListResource::collection($list_drive);
    }

    public function index()
    {
//         return DriveIndexResource::collection(Brand::all());
        return LaptopIndexResource::collection(Brand::where('type_id', 2)->get());
    }

    public function getSpecsAdmin($id)
    {
        $res = [];
        $drive = DriveSpecs::where('id', $id)->first();
        $res['dimension']=DriveDimension::find($drive->dimension_id)->value;
        $res['connect']=DriveConnect::find($drive->connect_id)->value;
        $res['read']=DriveRead::find($drive->read_id)->value;
        $res['write']=DriveRead::find($drive->write_id)->value;
        $res['rotation']=DriveRead::find($drive->rotation_id)->value;
        $res['cache']=DriveRead::find($drive->cache_id)->value;
        $res['type'] = DriveType::find($drive->type_id)->value;
        $res['capacity'] = DriveCapacity::find($drive->capacity_id)->value;
        return $res;
    }
}
