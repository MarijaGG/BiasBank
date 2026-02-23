<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Member extends Model
{
    public function group()
{
    return $this->belongsTo(Group::class);
}

public function photocards()
{
    return $this->hasMany(Photocard::class);
}

protected $fillable = [
    'group_id',
    'stage_name',
    'real_name',
    'birthday',
    'image',
    'emoji',
    'nationality',
];

    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return asset('images/member-placeholder.png');
        }

        if (Str::startsWith($this->image, 'images/')) {
            return asset($this->image);
        }

        return asset('storage/' . $this->image);
    }


}
