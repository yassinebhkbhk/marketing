<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalysePoste extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'analyse_poste';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'name',
        'period',
        'value',
        'description',
        'data',
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
    public function post()
    {
        return $this->belongsTo(post::class);
    }
}
