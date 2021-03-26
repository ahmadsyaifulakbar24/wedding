<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GreetingCard extends Model
{
    use HasFactory;

    protected $table = 'greeting_cards';
    protected $fillable = [
        'name', 
        'comment'
    ];

    public function wedding()
    {
        return $this->belongsTo(GreetingCard::class, 'wedding_id');
    }
}
