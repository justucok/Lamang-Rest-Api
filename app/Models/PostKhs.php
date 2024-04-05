<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostKhs extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_url',
        'semester',
        'academic_year',
    ];

    /**
     * file pdf
     *
     * @return Attribute
     */
    protected function pdf(): Attribute
    {
        return Attribute::make(
            get: fn ($pdf) => url('/storage/posts/pdf' . $pdf),
        );
    }
}
