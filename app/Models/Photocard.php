<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photocard extends Model
{
    protected $fillable = [
        'member_id',
        'album_id',
        'version',
        'average_price',
        'photo',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    // Optional helper to access group via member
    public function group()
    {
        return $this->member->group();
    }
}

