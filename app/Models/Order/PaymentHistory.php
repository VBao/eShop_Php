<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order\PaymentHistory
 *
 * @property int $id
 * @property string $order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentHistory whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentHistory extends Model
{
    use HasFactory;
}
