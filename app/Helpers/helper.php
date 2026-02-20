<?php

use App\CandidateStatus;
use App\CompanySetting;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

if (!function_exists('getYearsList')) {

    function getYearsList()
    {
        $keys = array_merge(range(date("Y"), 1910));
        $values = array_merge(range(date("Y"), 1910));
        $choice = array_combine($keys, $values);
        return $choice;
    }
}

if (!function_exists('getMonthsList')) {

    function getMonthsList()
    {
        return [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];
    }
}

if (!function_exists('getNoteRelatedModules')) {

    function getNoteRelatedModules()
    {
        return [
            1 => 'Client',
            2 => 'Contact',
            3 => 'Candidate',
            4 => 'Job'
        ];
    }
}

if (!function_exists('getMeetingRelatedModules')) {

    function getMeetingRelatedModules()
    {
        return [
            1 => 'Client',
            2 => 'Contact',
            3 => 'Job'
        ];
    }
}

if (!function_exists('getMeetingAttendeeRelatedModules')) {

    function getMeetingAttendeeRelatedModules()
    {
        return [
            1 => 'Candidate',
            2 => 'Contact',
            3 => 'User'
        ];
    }
}

if (!function_exists('getFormattedDate')) {

    function getFormattedDate($dateTime)
    {
        return Carbon::parse($dateTime)->format('Y-m-d');
    }
}

if (!function_exists('getFormattedReadableDateTime')) {

    function getFormattedReadableDateTime($dateTime)
    {
        return Carbon::parse($dateTime)->format("F j, Y, g:i a");
    }
}

if (!function_exists('getReadableTime')) {

    function getReadableTime($time)
    {
        return Carbon::parse($time)->format("g:i a");
    }
}

if (!function_exists('getFormattedReadableDate')) {

    function getFormattedReadableDate($dateTime)
    {
        return Carbon::parse($dateTime)->format("F j, Y");
    }
}
if (!function_exists('getMonthListFromDate')) {

    function getMonthListFromDate($startDate)
    {
        foreach (CarbonPeriod::create($startDate, '1 month', Carbon::today()) as $month) {
            $months[] = $month->format('F Y');
        }
        return $months;
    }
}

if (!function_exists('formatSpecialCharacter')) {

    function formatSpecialCharacter($string)
    {
        return ucwords(str_replace('_', ' ', $string));
    }
}

if (!function_exists('generateHexColors')) {

    /**
     * Return N Number of Color
     * @param $numberOfColor
     * @return array
     */
    function generateHexColors($numberOfColor): array
    {
        $colors = [];
        for ($i = 0; $i < $numberOfColor; $i++) {
            $colors[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        }
        return $colors;
    }
}

if (!function_exists('getDataTableActionColumn')) {

    /**
     * Return Datatable Action Button
     * @param $showUrl
     * @param $editUrl
     * @param $deleteUrl
     * @param $deleteMessage
     * @param $dataId
     * @return array|string
     */
    function getDataTableActionColumn($showUrl, $editUrl, $deleteUrl, $deleteMessage, $dataId)
    {
        $btn = '<a class="btn btn-info btn-icon btn-sm" data-toggle="tooltip"
                                               data-placement="top" title="' . __('Show') . '"
                                               href="' . $showUrl . '">
                                                <i class="fas fa-info-circle"></i>
                                            </a>';
        $btn = $btn . '<a class="btn btn-primary btn-icon btn-sm"
                                               data-toggle="tooltip"
                                               data-placement="top" title="' . __('Edit') . '"
                                               href="' . $editUrl . '"><i class="fas fa-pen"></i>
                                            </a>';
        $btn = $btn . '<button type="button"
                                           class="btn btn-danger btn-icon btn-sm btn-datatable-row-action"
                                           data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="Delete"
                                           data-id="' . $dataId . '"
                                           data-url="' . $deleteUrl . '"
                                           data-type="delete" data-title="' . __('Jobs') . ' Delete"
                                           data-message="' . $deleteMessage . '">
                                           <i class="fas fa-trash"></i>
                                       </button>';
        return $btn;
    }
}

if (!function_exists('getCandidateDataTableActionColumn')) {

    /**
     * Return Datatable Action Button
     * @param $showUrl
     * @param $dataId
     * @return array|string
     */
    function getCandidateDataTableActionColumn($showUrl, $dataId)
    {
        $btn = '<a class="btn btn-info btn-icon btn-sm" data-toggle="tooltip"
                                               data-placement="top" title="' . __('Show') . '"
                                               href="' . $showUrl . '">
                                                <i class="fas fa-info-circle"></i>
                                            </a>';
        return $btn;
    }
}

if (!function_exists('getCompanyNameUrl')) {
    function getCompanyNameUrl()
    {
        return CompanySetting::select('company_name', 'website', 'logo')->first();
    }
}

if (!function_exists('getCompanyLogo')) {
    function getCompanyLogo()
    {
        return CompanySetting::select('logo')->first();
    }
}

if (!function_exists('getCandidateStatus')) {
    /**
     * @param int|null $statusId
     * @return mixed
     */
    function getCandidateStatus(int $statusId = null)
    {
        return $statusId?CandidateStatus::where('id', $statusId)->first():null;
    }
}
