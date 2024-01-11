<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reimbursement extends Model
{
    protected $fillable = [
        'name',
        'employee_name',
        'subject',
        'value',
        'type',
        'start_date',
        'end_date',
        'notes',
        'description',
        'reimbursement_description',
        'employee_signature',
        'company_signature',
        'created_by',
        'status',
        'updated_by',
    ];

    public function reimbursement_type()
    {
        return $this->hasOne('App\Models\ReimbursementType', 'id', 'type');
    }


    public function files()
    {
        return $this->hasMany('App\Models\ReimbursementAttechment', 'reimbursement_id' , 'id');
    }

    public function employee()
    {
        return $this->hasOne('App\Models\User', 'id', 'employee_name');
    }

    public function comment()
    {
        return $this->hasMany('App\Models\ReimbursementComment', 'reimbursement_id', 'id');
    }
    public function note()
    {
        return $this->hasMany('App\Models\ReimbursementNote', 'reimbursement_id', 'id');
    }

    public function ReimbursementAttechment()
    {
        return $this->belongsTo('App\Models\ReimbursementAttechment', 'id', 'reimbursement_id');
    }

    public function ReimbursementComment()
    {
        return $this->belongsTo('App\Models\ReimbursementComment', 'id', 'reimbursement_id');
    }

    public function ReimbursementNote()
    {
        return $this->belongsTo('App\Models\ReimbursementNote', 'id', 'reimbursement_id');
    }
    public static function getReimbursementSummary($reimbursements)
    {
        $total = 0;

        foreach($reimbursements as $reimbursement)
        {
            $total += $reimbursement->value;
        }

        return \Auth::user()->priceFormat($total);
    }
    public static function status()
    {

        $status = [
            'accept' => 'Accept',
            'decline' => 'Decline',
            'review' => 'Review',

        ];
        return $status;
    }
}
