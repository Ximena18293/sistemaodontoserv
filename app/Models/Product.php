<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'status',
        'category_id', // Relación con la categoría (eliminando la marca directamente)
    ];

    /**
     * Relación con la categoría
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relación indirecta con la marca a través de la categoría
     */
    public function brand()
    {
        return $this->hasOneThrough(
            Brand::class, // Relaciona la marca
            Category::class, // Relaciona la categoría
            'id', // Clave foránea en la tabla de categorías
            'id', // Clave primaria de la marca
            'category_id', // Clave foránea en la tabla de productos
            'brand_id' // Clave foránea en la tabla de categorías
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
