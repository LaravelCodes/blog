<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Category extends Model
{
    use HasFactory;

    protected $appends = ['update_time'];
    protected $hidden = ['updated_at', 'created_at'];
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getUpdateTimeAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }
}
