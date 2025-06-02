<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $table = "cars";  

    protected $fillable = [
        "name",
        "price",
        "color",
        "status",
        "seat",
        "cc",
        "top_speed",
        "description",
        "location",
        "image_url",
        "category_id"
    ];

    public function category() {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
