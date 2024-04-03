<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment_id',
        'created_at',
        'message',
        'post_id', // ajout de la clé étrangère de la relation avec la table des postes
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // Si vous avez besoin de caster des attributs, vous pouvez les ajouter ici
    ];

    /**
     * Get the post that owns the comment.
     */
    public function poste()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function analyseCommentaires()
    {
        return $this->hasMany(AnalyseComment::class)->orderBy('date','desc');
    }
    public function analyzeComments()
{
    // Extraire les données pertinentes de la réponse API
    $data_to_store = [
        'comment_id' => $this->id, // En supposant que l'id existe dans les deux tables
        'like_count' => $this->message['like_count'],
        'user_likes' => $this->message['user_likes'],
        'comment_count' => $this->message['comment_count'],
        // ... autres champs à partir de la logique d'analyse
    ];

    // Créer une nouvelle instance `AnalyseCommentaire` et assigner les données
    $analyse_commentaire = new AnalyseComment;
    $analyse_commentaire->fill($data_to_store);

    // Enregistrer les données d'analyse (gestion des erreurs)
    try {
        $analyse_commentaire->save();
    } catch (\Exception $e) {
        // Gérer l'erreur de sauvegarde
        Log::error($e->getMessage());
    }

    return $analyse_commentaire; // Ou retourner des données spécifiques si nécessaire
}

}
