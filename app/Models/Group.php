<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function members()
{
    return $this->hasMany(Member::class);
}

public function albums()
{
    return $this->hasMany(Album::class);
}

public function photocards()
{
    return $this->hasMany(Photocard::class);
}


protected $fillable = [
    'name',
    'debut_date',
];

}
