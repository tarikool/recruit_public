<?php

namespace App\Http\Middleware;

use App\CompanySetting;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            $companySetting = CompanySetting::first();

            // Set Application language
            App::setLocale($companySetting->locale);

            // Set Application Timezone
            config(['app.timezone' => $companySetting->timezone]);
        }
        return $next($request);
    }
}
