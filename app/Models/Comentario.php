<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    //
    protected $table = 'comentarios';
    protected $fillable = ['publicacao_id', 'user_id','comentario'];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function publicacao(){
        return $this->belongsTo(Publicacao::class);
    }
    
}

