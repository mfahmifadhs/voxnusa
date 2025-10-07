<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pages extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "pages";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'status'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
