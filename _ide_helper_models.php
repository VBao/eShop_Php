<?php

// @formatter:off

/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Laptop {
    /**
     * App\Models\Laptop\Battery
     *
     * @method static \Illuminate\Database\Eloquent\Builder|Battery newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Battery newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Battery query()
     */
    class Battery extends \Eloquent
    {
    }
}

namespace App\Models\Product {
    /**
     * App\Models\Product\Brand
     *
     * @property int $id
     * @property string $brand
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product\productInfo[] $infos
     * @property-read int|null $infos_count
     * @method static \Illuminate\Database\Eloquent\Builder|Brand newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Brand newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Brand query()
     */
    class Brand extends \Eloquent
    {
    }
}

namespace App\Models\Product {
    /**
     * App\Models\Product\Image
     *
     * @property int $id
     * @property string $link_image
     * @property int $info_id
     * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Image query()
     */
    class Image extends \Eloquent
    {
    }
}

namespace App\Models\Product\Laptop {
    /**
     * App\Models\Product\Laptop\Cpu
     *
     * @property int $id
     * @property string $value
     * @method static \Illuminate\Database\Eloquent\Builder|Cpu newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Cpu newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Cpu query()
     */
    class Cpu extends \Eloquent
    {
    }
}

namespace App\Models\Product\Laptop {
    /**
     * App\Models\Product\Laptop\Gpu
     *
     * @property int $id
     * @property string $value
     * @method static \Illuminate\Database\Eloquent\Builder|Gpu newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Gpu newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Gpu query()
     */
    class Gpu extends \Eloquent
    {
    }
}

namespace App\Models\Product\Laptop {
    /**
     * App\Models\Product\Laptop\Os
     *
     * @property int $id
     * @property string $value
     * @method static \Illuminate\Database\Eloquent\Builder|Os newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Os newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Os query()
     */
    class Os extends \Eloquent
    {
    }
}

namespace App\Models\Product\Laptop {
    /**
     * App\Models\Product\Laptop\Port
     *
     * @property int $id
     * @property string $value
     * @method static \Illuminate\Database\Eloquent\Builder|Port newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Port newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Port query()
     */
    class Port extends \Eloquent
    {
    }
}

namespace App\Models\Product\Laptop {
    /**
     * App\Models\Product\Laptop\Ram
     *
     * @property int $id
     * @property string $value
     * @method static \Illuminate\Database\Eloquent\Builder|Ram newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Ram newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Ram query()
     */
    class Ram extends \Eloquent
    {
    }
}

namespace App\Models\Product\Laptop {
    /**
     * App\Models\Product\Laptop\Rom
     *
     * @property int $id
     * @property string $value
     * @method static \Illuminate\Database\Eloquent\Builder|Rom newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Rom newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Rom query()
     */
    class Rom extends \Eloquent
    {
    }
}

namespace App\Models\Product\Laptop {
    /**
     * App\Models\Product\Laptop\Screen
     *
     * @property int $id
     * @property string $value
     * @method static \Illuminate\Database\Eloquent\Builder|Screen newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Screen newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Screen query()
     */
    class Screen extends \Eloquent
    {
    }
}

namespace App\Models\Product\Laptop {
    /**
     * App\Models\Product\Laptop\Size
     *
     * @property int $id
     * @property string $value
     * @method static \Illuminate\Database\Eloquent\Builder|Size newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Size newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Size query()
     */
    class Size extends \Eloquent
    {
    }
}

namespace App\Models\Product\Laptop {
    /**
     * App\Models\Product\Laptop\Weight
     *
     * @property int $id
     * @property string $value
     * @method static \Illuminate\Database\Eloquent\Builder|Weight newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Weight newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Weight query()
     */
    class Weight extends \Eloquent
    {
    }
}

namespace App\Models\Product\Laptop {
    /**
     * App\Models\Product\Laptop\laptopSpec
     *
     * @property int $id
     * @property int $cpu_id
     * @property int $gpu_id
     * @property int $max_ram_id
     * @property int $ram_id
     * @property int $rom_id
     * @property int $os_id
     * @property int $battery_id
     * @property int $screen_id
     * @property int $weight_id
     * @property int $size_id
     * @property int $port_id
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|laptopSpec newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|laptopSpec newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|laptopSpec query()
     */
    class laptopSpec extends \Eloquent
    {
    }
}

namespace App\Models\Product\Laptop {
}

namespace App\Models\Product {
    /**
     * App\Models\Product\Type
     *
     * @property int $id
     * @property string $type
     * @method static \Illuminate\Database\Eloquent\Builder|Type newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Type newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Type query()
     */
    class Type extends \Eloquent
    {
    }
}

namespace App\Models\Product {
    /**
     * App\Models\Product\productInfo
     *
     * @property int $id
     * @property string $name
     * @property string $description
     * @property int $guarantee
     * @property int $price
     * @property int $brand_id
     * @property int $type_id
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \App\Models\Product\Brand $brands
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product\Image[] $images
     * @property-read int|null $images_count
     * @property-read \App\Models\Product\Type $types
     * @method static \Illuminate\Database\Eloquent\Builder|productInfo newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|productInfo newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|productInfo query()
     */
    class productInfo extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\User
     *
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
     * @property-read int|null $notifications_count
     * @method static \Database\Factories\UserFactory factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|User query()
     */
    class User extends \Eloquent
    {
    }
}

