<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = [
        'game_id','username' ,'pathImage','word',
    ];
    use HasFactory;
}
