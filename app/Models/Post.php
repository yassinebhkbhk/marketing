<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post'; // Specify the table name explicitly

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', // Updated to match the column name in the database
        'created_time', // Updated to match the column name in the database
        'page_id',
        'is_expired',
        'parent_id',
        'is_popular',
        'timeline_visibility',
        'promotion_status',
        'is_hidden',
        'is_published',
        'picture_url',
        'message',
        'type',
        'updated_time',
        'from_name',
        'from_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'Date' => 'date', // Assuming 'Date' is the correct column name in the database
    ];

    /**
     * Define the relationship with the Comment model.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class,'post_id');
    }

    /**
     * Define the relationship with the Page model.
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
    public $timestamps = false;
}
