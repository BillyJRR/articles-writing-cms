<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'author_id',
        'title',
        'body',
        'image',
        'status',
        'status_text',
        'slug',
    ];

    CONST STATUS_TEXT = [
        0 => 'Despublicado',
        1 => 'Publicado',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
