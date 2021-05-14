<?php


namespace App\Service\Impl;


use App\Http\Resources\DriveDetailsResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\InfoResource;
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
use App\Models\Product\Image;
use App\Models\Product\productInfo;
use App\Service\IDriveService;
use Illuminate\Http\Resources\Json\JsonResource;

class DriveImpl implements IDriveService
{

    public function getForm()
    {
        return [
            'capacities' => DriveCapacity::all(),
            'caches' => DriveCache::all(),
            'connections' => DriveConnect::all(),
            'writes' => DriveWrite::all(),
            'reads' => DriveRead::all(),
            'dimensions' => DriveDimension::all(),
            'rotations' => DriveRotation::all(),
            'types' => DriveType::all(),
            'brands' => Brand::query()->where('type_id', 2)->get(['id', 'brand']),
        ];
    }

    public function create($drive, $id)
    {
        $createDrive = new DriveSpecs;
        $createDrive->id = $id;
        foreach ($drive as $property => $value) {
            $createDrive->$property = $value;
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
        $info=[];
        $info[] = new InfoResource(productInfo::find($id));
        $info[] = new DriveDetailsResource(DriveSpecs::find($id));
        $res['info']=$info;
        $res['description']=$info[0]['description'];
        $res['images']=ImageResource::collection(Image::where('info_id',$id)->get());
        return $res;
    }

    public function list()
    {
        foreach (Brand::where('type_id','=',2)->get() as $brand){

        }
    }
}
