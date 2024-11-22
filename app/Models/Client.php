<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_name',
        'first_name',
        'last_name',
        'second_last_name',
        'email',
        'phone',
        'ciNit',
        'status',
    ];
}
