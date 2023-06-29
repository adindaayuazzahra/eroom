<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acara extends Model
{
    use HasFactory;
    protected $table = 'tb_acara';

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

    public function ruangan(){
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function acara(){
        return $this->hasMany(Waktu::class, 'id_acara');
    }
}
