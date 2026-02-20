<?php

namespace App\Http\Controllers;

use App\CompanySetting;
use App\Currency;
use App\Http\Requests\CompanySettingsRequest;
use App\LanguageSetting;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CompanySettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        $currencies = Currency::select('id', 'name', 'short_code')->get();
        $companySetting = CompanySetting::firstOrFail();
        $languageSettings = LanguageSetting::where('status', '1')->get();
        $currentLanguage = App::getLocale();
        $compact = compact('companySetting','languageSettings', 'timezones','currentLanguage','currencies');
        return view('company_settings.index', $compact);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param CompanySettingsRequest $request
     * @param CompanySetting $companySetting
     * @return RedirectResponse
     */
    public function update(CompanySettingsRequest $request, CompanySetting $companySetting)
    {

        $companySetting->company_name = $request->company_name;
        $companySetting->company_email = $request->company_email;
        $companySetting->company_phone = $request->company_phone;
        $companySetting->address = $request->address;
        $companySetting->website = $request->website;
        $companySetting->timezone = $request->timezone;
        $companySetting->locale = $request->locale_language;
        $companySetting->currency_id = $request->currency_id;
        $companySetting->latitude = $request->latitude;
        $companySetting->longitude = $request->longitude;

        // Logo Upload
        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            if (Storage::exists($companySetting->getBackendLogoLink())) {
                Storage::delete($companySetting->getBackendLogoLink());
            }

            $requestLogoFile = $request->file('logo');
            $requestLogoFileName = $requestLogoFile->getClientOriginalName();

            $companySetting->logo = $requestLogoFile->storeAs('logos', $requestLogoFileName,'public');
        }
        $companySetting->save();

        toastr()->success(__('Company Settings Updated Successfully'));

        return redirect()->back()->with(
            [
                'companySetting'=>$companySetting
            ]
        );
    }
}
