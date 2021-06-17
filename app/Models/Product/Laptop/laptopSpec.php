<?php

namespace App\Models\Product\Laptop;

use App\Models\Product\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class laptopSpec extends Model
{
    use HasFactory;

    public function port()
    {
        return $this->belongsTo(Port::class);
    }

    public function cpu()
    {
        return $this->belongsTo(Cpu::class);
    }

    public function gpu()
    {
        return $this->belongsTo(Gpu::class);
    }

    public function ram()
    {
        return $this->belongsTo(Ram::class);
    }

    public function rom()
    {
        return $this->belongsTo(Rom::class);
    }

    public function weight()
    {
        return $this->belongsTo(Weight::class);
    }

    public function os()
    {
        return $this->belongsTo(Os::class);
    }

    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function battery()
    {
        return $this->belongsTo(Battery::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
