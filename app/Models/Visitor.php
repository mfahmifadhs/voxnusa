<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "visitors";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'visited_at'
    ];
}
