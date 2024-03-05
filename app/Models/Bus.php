<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_number',
        'root_number',
        'type',
        'start',
        'starttime',
        'end',
        'endtime',
        'description',
        'image',
        'price',
        'status'
    ];
}
