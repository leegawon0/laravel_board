<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Boards extends Model
{
    use HasFactory, softDeletes;

    protected $guarded = ['id', 'created_at']; // 블랙리스트 방식

    protected $dates = ['deleted_at'];
}
