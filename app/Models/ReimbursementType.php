<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReimbursementType extends Model
{
    protected $fillable = [
        'name',
        'created_by',
    ];
}
