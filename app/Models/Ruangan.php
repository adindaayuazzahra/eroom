<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;
    protected $table = 'tb_ruangan';

    public function acaras(){
        return $this->hasMany(Acara::class, 'id_ruangan');
    }
    
}
