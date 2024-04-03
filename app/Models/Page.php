<?php

namespace App\Models;

use App\Models\AnalysePage;
use App\Models\User;
use App\Models\MediaSocial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'page'; // Specify the table name explicitly

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id',
        'user_id',
        'name_page',
        'categorie',
        'Location',
        'about',
        'email',
        'page_access_token',
        'link',
        'picture_url',
        'cover_picture_url',
        'rating_count',
        'fan_count',
        // Add 'link' to the fillable attributes
    ];

    /**
     * Define the relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define the relationship with the MediaSocial model.
     */
    public function mediaSocial()
    {
        return $this->belongsTo(MediaSocial::class);
    }

    /**
     * Define the relationship with the AnalysePage model.
     */
    public function analyses()
    {
        return $this->hasMany(AnalysePage::class);
    }

    /**
     * Define the relationship with the Post model.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
