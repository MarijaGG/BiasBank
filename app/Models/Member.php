<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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


}
