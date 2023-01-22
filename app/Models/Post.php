<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table='posts';
    protected $guarded=false;
    protected $with=['category', 'images'];

    public function category(){
        return $this->belongsTo(Category::class,'category_id', 'id');
    }

    public function images(){
        return $this->hasMany(Image::class, 'post_id', 'id');
    }

}
