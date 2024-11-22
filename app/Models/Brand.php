<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status'];

    /**
     * Relación con categorías
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Relación con productos a través de las categorías
     */
    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            Category::class,
            'brand_id', // Foreign key en categories
            'category_id', // Foreign key en products
            'id', // Local key en brands
            'id' // Local key en categories
        );
    }
}
