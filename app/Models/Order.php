<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property int $status_id
 * @property int $total
 * @property string $created_at
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereStatusId($value)
 * @method static Builder|Order whereTotal($value)
 * @method static Builder|Order whereUserId($value)
 * @mixin Eloquent
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string|null $note
 * @method static Builder|Order whereAddress($value)
 * @method static Builder|Order whereEmail($value)
 * @method static Builder|Order whereName($value)
 * @method static Builder|Order whereNote($value)
 * @method static Builder|Order wherePhone($value)
 */
class Order extends Model
{
    use HasFactory;

    public $timestamps = false;
}
