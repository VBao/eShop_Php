<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cart
 *
 * @property int $id
 * @property int $product_id
 * @property int $quantity
 * @property int $order_id
 * @method static Builder|Cart newModelQuery()
 * @method static Builder|Cart newQuery()
 * @method static Builder|Cart query()
 * @method static Builder|Cart whereId($value)
 * @method static Builder|Cart whereOrderId($value)
 * @method static Builder|Cart whereProductId($value)
 * @method static Builder|Cart whereQuantity($value)
 * @mixin Eloquent
 */
class Cart extends Model
{
    use HasFactory;

    public $timestamps = false;
}
