<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'from',
        'kafedra_id',
        'description',
        'room',
        'floor',
        'building',
        'status',
        'confirm'
    ];
}
