<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Image
 *
 * @property int $id
 * @property string $link_image
 * @property int $info_id
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereInfoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereLinkImage($value)
 * @mixin \Eloquent
 */
class Image extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function getById($id)
    {
        return $this->newQuery()->where('info_id', $id)->get();
    }
}
