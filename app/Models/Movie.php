<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function ratings()
    {
        return $this->belongsToMany(User::class, 'ratings');
    }

    protected $fillable = [
        'title',
        'image',
        'language',
        'genre',
        'premiered',
        'summary',
        'id_user',
    ];
}
