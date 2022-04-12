<?php

namespace App\Models\Product;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Product\Brand
 *
 * @property int $id
 * @property string $brand
 * @property int $type_id
 * @property-read Collection|productInfo[] $infos
 * @property-read int|null $infos_count
 * @method static Builder|Brand newModelQuery()
 * @method static Builder|Brand newQuery()
 * @method static Builder|Brand query()
 * @method static Builder|Brand whereBrand($value)
 * @method static Builder|Brand whereId($value)
 * @method static Builder|Brand whereTypeId($value)
 * @mixin Eloquent
 */
class Brand extends Model
{
    use HasFactory;

    public function infos(): HasMany
    {
        return $this->hasMany('App\Models\Product\productInfo', 'brand_id', 'id');
    }

    public function toArraysReact($id): array
    {
        $res = [];
        foreach (Brand::where('type_id', $id)->get() as $brand) {
            $temp_brand = [];
            $temp_brand['value'] = $brand->brand;
            $temp_brand['text'] = $brand->brand;
            $res[] = $temp_brand;
        }
        return $res;
    }

}
