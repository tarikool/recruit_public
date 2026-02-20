<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidateSource extends Model
{
    protected $guarded = [
      'id'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'status'
    ];
}
