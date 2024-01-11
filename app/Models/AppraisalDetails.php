<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppraisalDetails extends Model
{
    protected $fillable = [
        'appraisal_id',
        'input_value',
        'rating',
        'is_manager',
    ];

    public function appraisal()
    {
        return $this->belongsTo(App\Models\Appraisal::class);
    }


}
