<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class
productInfo extends Model
{
    use HasFactory;

//protected $casts=[
//    'brand'=>Brand::class,
//    'type'=>Type::class
//];
    public function images(): HasMany
    {
        return $this->hasMany('App\Models\Product\Image');
    }

    public function brands(): BelongsTo
    {
        return $this->belongsTo('App\Models\Product\Brand', 'id');
    }

    public function types(): BelongsTo
    {
//        return $this->belongsToMany('App\Models\Product\Type','types');
        return $this->belongsTo('App\Models\Product\Type', 'id');
    }

    public function getIndex(int $brand_id)
    {
        return $this->newQuery()->where('brand_id', $brand_id)->orderBy('id', 'desc')->limit(5)->get();
    }

    public function getById(int $id)
    {
        return $this->newQuery()->where('id', $id)->first();
    }

}
