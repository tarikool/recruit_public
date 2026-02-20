<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanySetting extends Model
{
    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'website',
        'address',
        'timezone',
        'latitude',
        'longitude',
        'locale',
        'currency_id',
        'logo'
    ];


    /**
     *
     * @return BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id','id');
    }

    /**
     * Return Logo For Frontend
     * @return string
     */
    public function getFrontLogoLink(): string
    {
        return $this->logo?asset('/storage/'.$this->logo):asset('assets/img/quickrecruit-logo.svg');
    }

    /**
     * Return Logo Location Link For Backend
     * @return string
     */
    public function getBackendLogoLink(): string
    {
        return '/public/'.$this->logo;
    }

}
