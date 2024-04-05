<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostPiket extends Model
{
    use HasFactory;

    protected $fillable = [
        'before_img_url',
        'after_img_url',
        'date',
    ];
}
