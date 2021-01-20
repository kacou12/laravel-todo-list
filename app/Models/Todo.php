<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $fillable = ['titre','description','creator_id',"done"];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function affectedTo()
    {
        return $this->belongsTo(User::class, 'affectedTo_id');
    }

    public function affectedBy()
    {
        return $this->belongsTo(User::class, 'affectedBy_id');
    }

    
}
