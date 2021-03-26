<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateSetting extends Model
{
    use HasFactory;

    protected $table = 'template_settings';
    protected $fillable = [
        'wedding_id', 
        'package',
        'theme', 
        'category_id'
    ];

    public function wedding()
    {
        return $this->hasOne(Wedding::class, 'wedding_id');
    }
}
