<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'subcategory_id')
            ->join('subcategories', 'categories.id', '=', 'subcategories.category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
