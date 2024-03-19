<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyseCommentaires extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'analyse_commentaires';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment_id',
        'like_count',
        'user_likes',
        'comment_count',
        'data',
        'date'
    ];
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // ... conversions de type si nécessaire
    ];

    /**
     * Get the related Commentaire for the Analyse_commentaires.
     */
    public function commentaire()
    {
        return $this->belongsTo(Commentaire::class);
    }
}
