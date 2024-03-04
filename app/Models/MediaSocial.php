<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaSocial extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'MediaSocial';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'socialMediaId',
        'socialMediaName',
        'Api_Url',
        'Api_Version',
    ];
    public function pages()
    {
        return $this->hasMany(Page::class);
    }
}
