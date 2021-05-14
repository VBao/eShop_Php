<?php

namespace App\Http\Resources;

use App\Models\Product\Drive\DriveSpecs;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        $res = [];
        $schema = Schema::getColumnListing('drive_specs');
        unset($schema['id']);
        foreach ($schema as $col) {
            if ($col == 'id') continue;
            $tableName = str_replace('_id', "", $col);
            $tempValue = DB::table('drive_'
                . (str_ends_with($tableName, 'y')
                    ? str_replace('y', "", $tableName) . 'ies'
                    : $tableName . 's'))
                ->where('id', '=', $this->$col)
                ->get()->first();
            $res[$tableName] = $tempValue->value;
        }
        return $res;
    }
}
