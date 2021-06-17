<?php

namespace App\Service\Impl;

use App\Models\Product\Brand;
use App\Models\Product\Type;
use App\Service\ITypeService;

class TypeImpl implements ITypeService
{

    protected Brand $type;

    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    public function getBrand(int $id): Brand
    {
        return $this->type->where('id', $id)->first();
    }

    public function getType(int $id)
    {
        // TODO: Implement getType() method.
    }
}
