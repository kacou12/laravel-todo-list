<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $fillable = ['titre','description',/*'auteur_membre_id','cible_membre_id',*/"done"];
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
