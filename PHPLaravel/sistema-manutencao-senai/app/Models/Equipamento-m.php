<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipamento-m extends Model
{
     protected $fillable = [
        "tag", "nome", "setor", "criticidade", "status"
        ];

 }

