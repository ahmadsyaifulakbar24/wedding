<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confirmation extends Model
{
    use HasFactory;

    protected $table = 'confirmations';
    protected $fillable = [
        'wedding_id', 
        'name', 
        'status'
    ];

    public function wedding()
    {
        return $this->belongsTo(Wedding::class, 'wedding_id');
    }
}
