<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Confirmation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'confirmations';
    protected $fillable = [
        'wedding_id', 
        'invitation_id', 
        'status'
    ];
}
