<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateImage extends Model
{
    use HasFactory;

    protected $table = 'template_images';
    protected $fillable = [
        'wedding_id', 
        'type', 
        'image', 
        'order'
    ];

    public function getImageUrlAttribute()
    {
        return $this->attributes['image'];
    }

    protected $appends = [
        'image_url'
    ];


    public function wedding()
    {
        return $this->belongsTo(Wedding::class, 'wedding_id');
    }

}
