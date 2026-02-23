<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Group;
use Illuminate\Support\Str;


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

    // Return a full URL for the album image. Supports either repo-tracked
    // `images/...` paths (served from public/images) or storage paths
    // (served from public/storage via the storage symlink).
    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return asset('images/album-placeholder.png');
        }

        if (Str::startsWith($this->image, 'images/')) {
            return asset($this->image);
        }

        return asset('storage/' . $this->image);
    }
}
