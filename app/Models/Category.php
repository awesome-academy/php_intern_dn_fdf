<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'parent_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'cate_id', 'id');
    }

    public function suggestProducts()
    {
        return $this->hasMany(Suggest::class, 'cate_id');
    }

    public function childCategories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function scopeIsParent($query)
    {
        return $query->where('parent_id', null);
    }

    public function scopeIsChild($query)
    {
        return $query->where('parent_id', '!=', null);
    }
}
