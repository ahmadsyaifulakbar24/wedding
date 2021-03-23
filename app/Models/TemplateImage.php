<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'template_images';
    protected $fillable = [
        'template_setting_id', 
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

    public function template_setting()
    {
        return $this->belongsTo(TemplateSetting::class, 'template_setting_id');
    }

}
