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
        'post_id', // Changed 'ID_Poste' to 'post_id' to match database column name
        'created_time', // Changed 'Date' to 'created_time' to match database column name
        'page_id',
        'is_expired',
        'parent_id',
        'is_popular',
        'timeline_visibility',
        'promotion_status',
        'is_hidden',
        'is_published',
        'updated_time',
        'from_name',
        'from_id',
    ];
    public $timestamps = false;



    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'Date' => 'date',
    ];

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
