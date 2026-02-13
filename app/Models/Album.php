<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Group;


class Album extends Model
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
        'name',
        'release_date',
        'track_count',
        'title_track',
        'price',
        'image',
];
}
