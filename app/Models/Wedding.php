<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wedding extends Model
{
    use HasFactory;

    protected $table = 'weddings';
    protected $fillable = [
        'slug',
        'order_name',
        'order_email',
        'order_phone_number',

        'groom_full_name',
        'groom_short_name',
        'groom_child_order',
        'groom_father_name',
        'groom_mother_name',
        'groom_instagram',

        'bride_full_name',
        'bride_short_name',
        'bride_child_order',
        'bride_father_name',
        'bride_mother_name',
        'bride_instagram',

        'reception_date',
        'reception_address',

        'contract_date',
        'contract_address',
        'location',
        'active',
    ];

    public function template_setting()
    {
        return $this->hasOne(TemplateSetting::class, 'wedding_id');
    }

    public function template_image()
    {
        return $this->hasMany(TemplateImage::class, 'wedding_id');
    }

    public function confirmation()
    {
        return $this->hasMany(Confirmation::class, 'wedding_id');
    }

    public function greeting_card()
    {
        return $this->hasMany(GreetingCard::class, 'wedding_id');
    }
}
