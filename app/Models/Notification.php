<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 
        'notifiable_type', 
        'notifiable_id', 
        'data', 
        'slug', 
        'read_at'
    ];

    protected $keyType = 'string';
    protected $casts = [
        'id' => 'string'
    ];

    public function notifiable()
    {
       return $this->morphTo();
    }
}
