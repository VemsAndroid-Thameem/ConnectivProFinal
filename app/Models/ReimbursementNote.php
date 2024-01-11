<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReimbursementNote extends Model
{
    protected $fillable = [
        'reimbursement_id',
        'user_id',
        'note',
    ];
}
