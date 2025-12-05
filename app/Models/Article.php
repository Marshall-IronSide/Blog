<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'titre',
        'contenu',
        'user_id',
        'banner_image'
    ];
    // Relation avec User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation : Un article peut avoir plusieurs commentaires

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    // Accesseur pour obtenir le nom de l'auteur
    public function getAuteurAttribute()
    {
        return $this->user ? $this->user->full_name : 'Système';
    }
}
