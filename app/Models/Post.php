<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ID_Poste',
        'Date',
        'description',
        'page_id', // Ajout de la clé étrangère pour la relation
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'Date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    // Définition de la relation avec la table "pages"
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
