<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateSetting extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'template_settings';
    protected $fillable = [
        'wedding_id', 
        'theme', 
        'category_id'
    ];

    public function wedding()
    {
        return $this->hasOne(Wedding::class, 'wedding_id');
    }

    public function template_image()
    {
        return $this->hasMany(TemplateImage::class, 'template_setting_id');
    }
}
