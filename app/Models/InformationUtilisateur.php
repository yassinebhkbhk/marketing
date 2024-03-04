<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationUtilisateur extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'access_token',
        'expiration_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expiration_date' => 'datetime',
    ];

    /**
     * Get the user that owns the user information.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
