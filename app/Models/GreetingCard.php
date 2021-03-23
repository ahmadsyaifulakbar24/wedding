<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GreetingCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'greeting_cards';
    protected $fillable = [
        'invitation_id', 
        'comment'
    ];
}
