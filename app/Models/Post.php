<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "posts";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'reviewer_id',
        'sub_category_id',
        'title',
        'slug',
        'content',
        'thumbnail',
        'status',
        'notes',
        'published_at',
        'views'
    ];

    public function reviewer() {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category() {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function subCategory() {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    public function postTag()
    {
        return $this->hasMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }
}
