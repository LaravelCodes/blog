<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

    // Post::create(['title'=>...]) Tinker Masss Assignment
    protected $fillable = ['title', 'body', 'slug', 'category_id'];
    // Error: id not guarded
    protected $guarded = ['id'];
    // ALTER TABLE posts AUTO_INCREMENT=7

    // Hidden Fields
    protected $hidden = ['updated_at', 'created_at'];

    
    protected $appends = ['update_time', 'fake_image'];

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d M, Y');
    }
    public function getUpdateTimeAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }
    public function getFakeImageAttribute()
    {
        $image = ['display', 'display-1', 'display-2', 'display-3'];
        return asset("storage/Images/".$image[mt_rand(0,3)].".jpg");
        // return asset("Images/display-2.jpg");
    }

    // Route Model Binding using wilcard
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Eloquent Relationships
    // hasOne, hasMany, belongsTo, BelongsToMany, etc
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
