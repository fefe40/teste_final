<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deslike extends Model
{
    protected $fillable = ['publicacao_id', 'user_id', 'createdAt', 'updatedAt'];

    public function publicacao()
    {
        return $this->belongsTo(Publicacao::class, 'publicacao_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
