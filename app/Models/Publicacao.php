<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacao extends Model
{
    //
    protected $table = 'publicacao';
    protected $fillable = ['foto','titulo_prato','local','cidade','empresa_id','createdAt','updatedAt'];
    public $timestamps = false;

    public function comentarios(){
        return $this->hasMany(Comentario::class);
    }

    public function likes()
    {
        return $this->hasMany(\App\Models\Like::class, 'publicacao_id');
    }

    public function deslikes()
    {
        return $this->hasMany(\App\Models\Deslike::class, 'publicacao_id');
    }

}
