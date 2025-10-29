<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    //
    protected $table = 'empresa';
    protected $fillable = ['nome','logo','createdAt','updatedAt'];
    public $timestamps = false;
}
