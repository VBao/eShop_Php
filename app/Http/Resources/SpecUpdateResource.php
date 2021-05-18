<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecUpdateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent=>=>toArray($request);
        return [
            "capacity_id" => $this->capacity_id,
            "cache_id" => $this->cache_id,
            "connect_id" => $this->connect_id,
            "write_id" => $this->write_id,
            "read_id" => $this->read_id,
            "dimension_id" => $this->dimension_id,
            "rotation_id" => $this->rotation_id,
            "drive_type_id" => $this->type_id
        ];
    }
}
