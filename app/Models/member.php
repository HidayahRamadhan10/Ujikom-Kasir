<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'name',
        'phone_number',
        'points',
        'member_since'
    ];

    protected $dates = [
        'member_since',
        'created_at',
        'updated_at'
    ];
}