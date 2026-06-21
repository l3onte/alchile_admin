<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'status'
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function ingredients() {
        return $this->hasMany(RecipeIngredient::class, 'recipe_id');
    }

    public function ingredientProduct() {
        return $this->hasManyThrough(
            Product::class,
            RecipeIngredient::class,
            'recipe_id',
            'id',
            'id',
            'ingredient_id'
        );
    }
}
