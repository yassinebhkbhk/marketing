<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalysePage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Analyse_Page';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // Liste des attributs remplissables en masse
        'page_id',
        'name',
        'period',
        'value',
        'description',
        'data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        // Liste des attributs à caster
        'data' => 'json',
        'date' => 'date',
    ];
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
