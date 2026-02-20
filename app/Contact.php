<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
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
        'first_name',
        'last_name',
        'client_id',
        'email',
        'fax',
        'number',
        'job_title',
        'twitter_profile_url',
        'linkedin_profile_url',
        'billing_street',
        'billing_city',
        'billing_state',
        'billing_code',
        'billing_country_id',
        'shipping_street',
        'shipping_city',
        'shipping_state',
        'shipping_code',
        'shipping_country_id',
        'client_source_id',
        'created_by',
        'attached_others',
        'status',
    ];


    protected $appends = ['name'];


    public function getNameAttribute()
    {
        return ucwords($this->first_name.' '.$this->last_name);
    }


    /**
     * A Contact belongsTo a Client
     * @return BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class,'client_id','id');
    }

    /**
     * A Contact can have multiple job posting
     * @return HasMany
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * A Contact can have multiple task
     * @return HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * A client can have multiple call
     * @return HasMany
     */
    public function calls()
    {
        return $this->hasMany(Call::class);
    }

    /**
     * A Contact Have a Source
     * @return BelongsTo
     */
    public function client_source()
    {
        return $this->belongsTo(ClientSource::class,'client_source_id','id');
    }


    /**
     * Contact Creator
     * @return BelongsTo
     */
    public function contact_owner()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    /**
     * Contact Billing Country Address
     * @return BelongsTo
     */
    public function billing_country(){
        return $this->belongsTo(Country::class,'billing_country_id','id');
    }

    /**
     * Contact Shipping Country Address
     * @return BelongsTo
     */
    public function shipping_country(){
        return $this->belongsTo(Country::class,'shipping_country_id','id');
    }


    /**
     * Full Name of Contact
     * @return string
     */
    public function full_name(){
        $full_name = $this->first_name." ".$this->last_name;
        return ucfirst($full_name);
    }


    //join In Meeting As A Collaborator
    public function collaborateMeeting()
    {
        return $this->morphMany(Meeting::class, 'collaboratable');
    }

    //Join Meeting As Attendee
    public function attendMeetings()
    {
        return $this->morphToMany(Meeting::class, 'attendable', Attendee::class);
    }


}
