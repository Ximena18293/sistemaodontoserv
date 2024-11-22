<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'brand_id', 
        'status'
    ]; // Añadir brand_id

    /**
     * Relación con los productos
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Relación con la marca
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
