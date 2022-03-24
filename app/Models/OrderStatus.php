<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderStatus
 *
 * @property int $id
 * @property string $status
 * @method static Builder|OrderStatus newModelQuery()
 * @method static Builder|OrderStatus newQuery()
 * @method static Builder|OrderStatus query()
 * @method static Builder|OrderStatus whereId($value)
 * @method static Builder|OrderStatus whereStatus($value)
 * @mixin Eloquent
 */
class OrderStatus extends Model
{
    use HasFactory;
}
