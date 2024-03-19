<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id',
        'user_id',
        'NomPage',
        'Categorie',
        'Location',
        'page_access_token',
        'link', // Add 'link' to the fillable attributes
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Media_social()
    {
        return $this->belongsTo(MediaSocial::class);
    }

    public function analyses()
    {
        return $this->hasMany(AnalysePages::class);
    }

    // Définition de la relation avec la table "posts"
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
