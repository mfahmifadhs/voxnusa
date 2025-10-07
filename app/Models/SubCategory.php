<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "sub_categories";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'name',
        'slug'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function posts() {
        return $this->hasMany(Post::class, 'sub_category_id');
    }
}
