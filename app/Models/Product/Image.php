<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    public $timestamps=false;

    public function getById($id){
        return $this->newQuery()->where('info_id',$id)->get();
    }
}
