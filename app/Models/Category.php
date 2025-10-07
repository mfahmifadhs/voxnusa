<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "categories";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    public function post() {
        return $this->hasManyThrough(Post::class, SubCategory::class);
    }

    public function subCategory() {
        return $this->hasMany(SubCategory::class, 'category_id');
    }
}
