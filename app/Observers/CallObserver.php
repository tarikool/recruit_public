<?php

namespace App\Observers;

use App\Call;
use App\Notifications\CallNotification;
use Illuminate\Support\Facades\Log;

class CallObserver
{
    /**
     * Handle the call "created" event.
     *
     * @param Call $call
     * @return void
     */
    public function created(Call $call)
    {
        $createdBy = $call->creator->fullName() ?? 'N/A';
        $details = [
            'subject' => $call->topic . ' -' . __('Call Has Been Created With You'),
            'greeting' => __('Hi') . ' ' . $call->contact->full_name() . ',',
            'body' => __("A Call Has Been Arranged With You by $createdBy. You Are Requested To Join The Call At") . " " .
                getFormattedReadableDate($call->start_date) . ', ' . getReadableTime($call->start_time),
            'thanks' => __('Thank you for your patience!'),
        ];

        if (env('MAIL_USERNAME') && env('MAIL_PASSWORD')){
            $call->contact->notify(new CallNotification($details));
        } else{
            Log::warning("Please Setup Mail username, password, protocol and necessary credentials");
        }
    }

    /**
     * Handle the call "updated" event.
     *
     * @param Call $call
     * @return void
     */
    public function updated(Call $call)
    {
        $details = [
            'subject' => $call->topic . ' -' . __('Call Has Been Updated'),
            'greeting' => __('Hi') . ' ' . $call->contact->full_name() . ',',
            'body' => __("Call Has Been Updated. Call is Scheduled At") . ' ' .
                getFormattedReadableDate($call->start_date) . ', ' . getReadableTime($call->start_time),
            'thanks' => __('Thank you for your patience!'),
        ];

        if (env('MAIL_USERNAME') && env('MAIL_PASSWORD')){
            $call->contact->notify(new CallNotification($details));
        } else{
            Log::warning("Please Setup Mail username, password, protocol and necessary credentials");
        }
    }

    /**
     * Handle the call "deleted" event.
     *
     * @param Call $call
     * @return void
     */
    public function deleted(Call $call)
    {
        $createdBy = $call->creator->fullName() ?? 'N/A';

        $details = [
            'subject' => $call->topic . ' -' . __('Call Has Been Cancelled'),
            'greeting' => __('Hi') . ' ' . $call->contact->full_name() . ',',
            'body' => __("Call Scheduled By $createdBy on ") . getFormattedReadableDate($call->start_date) . ', ' . getReadableTime($call->start_time)." Has Been Cancelled. ",
            'thanks' => __('Thank you for your patience!'),
        ];

        if (env('MAIL_USERNAME') && env('MAIL_PASSWORD')){
            $call->contact->notify(new CallNotification($details));
        } else{
            Log::warning("Please Setup Mail username, password, protocol and necessary credentials");
        }
    }

    /**
     * Handle the call "restored" event.
     *
     * @param Call $call
     * @return void
     */
    public function restored(Call $call)
    {
        //
    }

    /**
     * Handle the call "force deleted" event.
     *
     * @param Call $call
     * @return void
     */
    public function forceDeleted(Call $call)
    {
        //
    }
}
