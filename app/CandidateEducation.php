<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidateEducation extends Model
{
    protected $table = 'candidate_educations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'candidate_id',
        'institute',
        'major',
        'degree',
        'start_month',
        'start_year',
        'end_month',
        'end_year',
        'current_institution',
        'status'
    ];

}
