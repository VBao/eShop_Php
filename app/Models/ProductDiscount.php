<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductDiscount
 *
 * @property int $id
 * @property int $product_id
 * @property int $percent
 * @property int $discount_price
 * @property string $start_date
 * @property string $end_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ProductDiscount newModelQuery()
 * @method static Builder|ProductDiscount newQuery()
 * @method static Builder|ProductDiscount query()
 * @method static Builder|ProductDiscount whereCreatedAt($value)
 * @method static Builder|ProductDiscount whereDiscountPrice($value)
 * @method static Builder|ProductDiscount whereEndDate($value)
 * @method static Builder|ProductDiscount whereId($value)
 * @method static Builder|ProductDiscount wherePercent($value)
 * @method static Builder|ProductDiscount whereProductId($value)
 * @method static Builder|ProductDiscount whereStartDate($value)
 * @method static Builder|ProductDiscount whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ProductDiscount extends Model
{
    public function product():BelongsTo{
        return $this->belongsTo('App\Models\Product\productInfo');
    }
    use HasFactory;
}
