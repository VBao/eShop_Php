<?php

namespace App\Http\Resources;

use App\Models\Product\Brand;
use App\Models\Product\Drive\DriveRead;
use App\Models\Product\Drive\DriveRotation;
use App\Models\Product\Drive\DriveWrite;
use App\Models\Product\Image;
use App\Models\Product\productInfo;
use Illuminate\Http\Resources\Json\JsonResource;

class DriveDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        $res = [];
//        $schema = Schema::getColumnListing('drive_specs');
//        unset($schema['id']);
//        foreach ($schema as $col) {
//            if ($col == 'id') continue;
//            $tableName = str_replace('_id', "", $col);
//            $tempValue = DB::table('drive_'
//                . (str_ends_with($tableName, 'y')
//                    ? str_replace('y', "", $tableName) . 'ies'
//                    : $tableName . 's'))
//                ->where('id', '=', $this->$col)
//                ->get()->first();
//            $res[$tableName] = $tempValue->value;
//        }
//        return $res;
        $info = productInfo::find($this->id);
        return [
            'id' => $this->id,
            'info' => ['name' => $info->name,
                'guarantee' => $info->guarantee,
                'price' => $info->price,
                'brand' => Brand::where('id', $info->brand_id)->get(['id', 'brand'])->first()->brand,
                'read' => DriveRead::find($this->read_id)->value,
                'write' => DriveWrite::find($this->write_id)->value,
                'cache' => DriveRead::find($this->cache_id)->value,
                'rotation' => DriveRotation::find($this->rotation_id)->value,
                'type' => DriveRead::find($this->type_id)->value,
                'connect' => DriveRead::find($this->connect_id)->value,
                'capacity' => DriveRead::find($this->capacity_id)->value,
                'dimension' => DriveRead::find($this->dimension_id)->value,],
            'description' => $info->description,
            'images' => ImageResource::collection(Image::where('info_id', $this->id)->get())
        ];
    }
}
