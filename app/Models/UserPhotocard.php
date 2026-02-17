<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPhotocard extends Model
{
    protected $fillable = [
        'user_id',
        'photocard_id',
        'purchase_price',
        'condition',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photocard()
    {
        return $this->belongsTo(Photocard::class);
    }
}
