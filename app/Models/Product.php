<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = [
        'category_id', 'name', 'description', 'image', 'price', 'is_published'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
