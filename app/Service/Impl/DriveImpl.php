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
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

class DriveImpl implements IDriveService
{

    protected DriveSpecs $driveSpecs;

    /**
     * @param DriveSpecs $driveSpecs
     */
    public function __construct(DriveSpecs $driveSpecs)
    {
        $this->driveSpecs = $driveSpecs;
    }

    #[ArrayShape(['info' => "array", 'spec' => "array"])] public function getForm(): array
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

    public function create($drive, $id): DriveSpecs
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

    public function update($drive): DriveDetailsResource
    {
        $createDrive = DriveSpecs::query()->where('id', $drive->id)->first();
        foreach ($drive as $property => $value) {
            $createDrive->$property = $value;
        }
        $createDrive->save();
        return $this->get($drive->id);
    }


    public function get($id): DriveDetailsResource
    {
        //        $info=[];
//        $info[] = new InfoResource(productInfo::find($id));
        //        $res['info']=$info;
//        $res['description']=$info[0]['description'];
//        $res['images']=ImageResource::collection(Image::where('info_id',$id)->get());
        return new DriveDetailsResource(DriveSpecs::find($id));
    }

    public function list(): Collection
    {
        return productInfo::limit(12)->offset(12)->get();
//        return productInfo::where('type_id', 2)->get();
    }

    public function filter(array $filter): AnonymousResourceCollection
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

    public function index(): AnonymousResourceCollection
    {
//         return DriveIndexResource::collection(Brand::all());
        return LaptopIndexResource::collection(Brand::where('type_id', 2)->get());
    }

    public function getSpecsAdmin($id): array
    {
        $res = [];
        $drive = DriveSpecs::where('id', $id)->first();
        $res['dimension'] = DriveDimension::find($drive->dimension_id)->value;
        $res['connect'] = DriveConnect::find($drive->connect_id)->value;
        $res['read'] = DriveRead::find($drive->read_id)->value;
        $res['write'] = DriveRead::find($drive->write_id)->value;
        $res['rotation'] = DriveRead::find($drive->rotation_id)->value;
        $res['cache'] = DriveRead::find($drive->cache_id)->value;
        $res['type'] = DriveType::find($drive->type_id)->value;
        $res['capacity'] = DriveCapacity::find($drive->capacity_id)->value;
        return $res;
    }

    public function postFilter(array $brand_list, array $capacity_list, array $type_list, array $price, string $search = null): array
    {
//        Search by brand and price
        if (count($brand_list) != 0) {
            if (count($price) != 0) {
                $temp_drive = count($price) == 1 ?
                    productInfo::where('type_id', '=', 2)->whereIn('brand_id', $brand_list)->whereBetween('price', [0, $price[0]]) :
                    productInfo::where('type_id', '=', 2)->whereIn('brand_id', $brand_list)->whereBetween('price', [$price[0], $price[1]]);
            } else {
                $temp_drive = productInfo::where('type_id', '=', 2)->whereIn('brand_id', $brand_list);
            }
        } else {
            if (count($price) != 0) {
                $temp_drive = count($price) == 1 ?
                    productInfo::where('type_id', '=', 2)->whereBetween('price', [0, $price[0]]) :
                    productInfo::where('type_id', '=', 2)->whereBetween('price', [$price[0], $price[0]]);
            } else {
                $temp_drive = productInfo::where('type_id', '=', 2);
            }
        }

//        Add search by keyword
        if ($search != null) {
            $temp_drive = $temp_drive->where('name', 'LIKE', '%' . $search . '%')->get();
        } else {
            $temp_drive = $temp_drive->get();
        }

        if (count($capacity_list) != 0 || count($type_list) != 0) {
            if (count($capacity_list) != 0)
                foreach ($capacity_list as $capacity_keyword)
                    foreach ($temp_drive as $i => $value) {
                        $delete = true;
                        foreach (DriveCapacity::where('value', 'LIKE', "%" . $capacity_keyword . "%")->get() as $capacity_id) {
                            $spec = $this->driveSpecs::query()->where('id', '=', $temp_drive[$i]->id)->first();
                            if ($spec->capacity_id == $capacity_id->id) $delete = false;
                        }
                        if ($delete) unset($temp_drive[$i]);
                    }

            if (count($type_list) != 0)
                foreach ($type_list as $type_keyword)
                    foreach ($temp_drive as $i => $value) {
                        $delete = true;
                        foreach (DriveType::where('value', 'LIKE', $type_keyword)->get() as $type_id) {
                            $spec = $this->driveSpecs::where('id', '=', $temp_drive[$i]->id)->first();
                            if ($spec->type_id == $type_id->id) $delete = false;
                        }
                        if ($delete) unset($temp_drive[$i]);
                    }
        }
        $result = [];
        foreach ($temp_drive as $drive) {
            $result[] = new DriveListResource($drive);
        }
        return $result;
    }

    #[ArrayShape(['brand' => "array", 'capacity' => "array", 'drive_type' => "array"])] public function filterCheck(array $brand_list, array $capacity_list, array $type_list): array
    {
        $brand_list_result = [];
        $brand = Brand::query()->where('type_id', '=', 2)->get(['id', 'brand']);
        foreach ($brand as $value)
            $brand_list_result[] = [
                'id' => $value->id,
                'value' => $value->brand,
                'active' => (count($brand_list) != 0 && in_array($value->id, $brand_list))
            ];

        $capacity_filter = $this->capacityFilter($capacity_list);
        $type_filter = $this->typeFilter($type_list);

        return [
            'brand' => $brand_list_result,
            'capacity' => $capacity_filter,
            'drive_type' => $type_filter
        ];
    }

    private function capacityFilter(array $capacity_list): array
    {
        $capacityList = [];
        $capacityCheck = [];
        $capacities = [];
        foreach (DriveCapacity::all() as $item) {
            $capacity_value = explode(', ', $item->value, 2)[0];
            if (!in_array($capacity_value, $capacityList)) {
                $capacityList[] = $capacity_value;
            }
        }
        if (count($capacity_list) != 0) foreach ($capacity_list as $searchCapacity) {
            $activeType = DriveCapacity::query()->where('value', 'LIKE', "%" . $searchCapacity . "%")->get(['id']);
            if (!is_null($activeType)) {
                $capacityCheck[] = $searchCapacity;
                $capacities[] = ['value' => $searchCapacity, 'active' => true];
            }
        }
        foreach (array_diff($capacityList, $capacityCheck) as $inactiveType) {
            $capacities[] = ['value' => $inactiveType, 'active' => false];
        }
        return $capacities;
    }

    private function typeFilter(array $type_list): array
    {
        $typeList = [];
        $typeCheck = [];
        $types = [];
        foreach (DriveType::all() as $item) {
            $type_value = explode(', ', $item->value, 2)[0];
            if (!in_array($type_value, $typeList)) {
                $typeList[] = $type_value;
            }
        }
        if (count($type_list) != 0) foreach ($type_list as $searchType) {
            $activeType = DriveType::query()->where('value', 'LIKE', $searchType)->get(['id']);
            if (!is_null($activeType)) {
                $typeCheck[] = $searchType;
                $types[] = ['value' => $searchType, 'active' => true];
            }
        }
        foreach (array_diff($typeList, $typeCheck) as $inactiveType) {
            $types[] = ['value' => $inactiveType, 'active' => false];
        }
        return $types;
    }
}
