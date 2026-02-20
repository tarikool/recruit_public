<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Candidate extends Model
{
    use Notifiable;

    protected $guarded = [
        'id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'image',
        'number',
        'user_id',
        'fax',
        'website',
        'street',
        'city',
        'state',
        'code',
        'country_id',
        'total_year_of_experience',
        'highest_qualification',
        'expected_salary',
        'skillset',
        'additional_info',
        'twitter_profile_url',
        'skype_profile_url',
        'candidate_source_id',
        'created_by',
        'resume',
        'cover_letter',
        'contracts',
        'relocate_willing',
        'status'
    ];


    protected $appends = ['email', 'name',];


    public function full_name()
    {
        $full_name = $this->user->first_name . " " . $this->user->last_name;
        return ucfirst($full_name);
    }

    public function candidate_status()
    {
        return $this->belongsTo(CandidateStatus::class, 'candidate_status_id', 'id');
    }

    public function candidate_source()
    {
        return $this->belongsTo(CandidateSource::class, 'candidate_source_id', 'id');
    }

    public function educations()
    {
        return $this->hasMany(CandidateEducation::class);
    }

    public function experiences()
    {
        return $this->hasMany(CandidateExperience::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function assignedJobs()
    {
        return $this->belongsToMany(Job::class, 'assign_jobs', 'candidate_id', 'job_id')
            ->withPivot(['candidate_status_id'])
            ->withTimestamps();
    }

    //Join Meeting As Attendee
    public function attendMeetings()
    {
        return $this->morphToMany(Meeting::class, 'attendable', Attendee::class);
    }


    public function getEmail()
    {
        return $this->user->email;
    }


    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    public function getNameAttribute()
    {
        return $this->user->first_name . ' ' . $this->user->last_name;
    }

    /**
     * Return Candidate Image For Frontend
     * @return string
     */
    public function getFrontLogoLink(): string
    {
        return $this->image ? asset('/storage/' . $this->image) : asset('assets/img/avatar/candidate-avatar.png');
    }

    /**
     * Return Candidate Image Link For Backend
     * @return string
     */
    public function getBackendImageLink(): string
    {
        return '/public/' . $this->image;
    }


}
