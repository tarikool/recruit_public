<?php

namespace App\Traits;



use App\AssignJob;
use App\Candidate;
use App\Notifications\JobAssignedToCandidates;

trait JobAssociationTrait
{

    public function assignNewCandidatesToJob($job, $input)
    {
        $candidate = Candidate::findOrFail($input['candidate_id']);

        $assignJob = new AssignJob();
        $assignJob->job_id = $job->id;
        $assignJob->candidate_id = $input['candidate_id'];
        $assignJob->candidate_status_id = $input['candidate_status'];
        $assignJob->save();

        $job_url = url('job-details/'.$job->slug);
        $details['subject'] = "New Job Assigned";
        $details['greeting'] = "Hi " . $assignJob->candidate->full_name() . ",";
        $details['body'] = "Your candidate profile has been associated with {$job->job_title} by Recruiters. " .
            "Your current status is " . $assignJob->candidateStatus->name .
            ". You can see the job details in this link - {$job_url}";
        $details['thanks'] = "Thank you for your patience!";

        $this->sendJobAssociationNotification($candidate, $details);
    }


    public function updateCandidateStatus($assignJob, $candidateStatusId, $job)
    {
        $assignJob->candidate_status_id = $candidateStatusId;
        $assignJob->save();

        $job_url = url('job-details/'.$job->slug);
        $details['subject'] = "Candidate status updated";
        $details['greeting'] = "Hi " . $assignJob->candidate->full_name() . ",";
        $details['body'] = "Your candidate status has been updated by Recruiters. ".
            "Your current status is " . $assignJob->candidateStatus->name .
            ". You can see the job details in this link - {$job_url}";
        $details['thanks'] = "Thank you for your patience!";

        $this->sendJobAssociationNotification($assignJob->candidate, $details);
    }


    public function removeCandidatesFromJob($removeCandidates, $job)
    {
        $candidates = Candidate::whereIn('id', $removeCandidates->pluck('candidate_id'))->get();
        $removeCandidates->forceDelete();

        foreach ($candidates as $candidate){
            $job_url = url('job-details/'.$job->slug);
            $details['subject'] = "Associated Job Removed";
            $details['greeting'] = "Hi " . $candidate->full_name() . ",";
            $details['body'] = "Your profile has been removed from the {$job->job_title} job by Recruiters. ".
                " You can see the job details in this link - {$job_url}";
            $details['thanks'] = "Thank you for your patience!";

            $this->sendJobAssociationNotification($candidate, $details);
        }
    }




    public function sendJobAssociationNotification($candidate, $details)
    {
        $candidate->details = [
            'subject' => __($details['subject']),
            'greeting' => __($details['greeting']),
            'body' => __($details['body']),
            'thanks' => __($details['thanks']),
        ];

        if (env('MAIL_USERNAME') && env('MAIL_PASSWORD')){
            $candidate->notify(new JobAssignedToCandidates());
        }

    }



    public function notifyContactAboutJobUpdates($job)
    {
        $contact = $job->contact;
        $job_url = url('job-details/'.$job->slug);
        $contact->details = [
            'subject' => __("Associated candidates updated"),
            'greeting' => __("Hi {$contact->full_name()},"),
            'body' => __("Associated candidates has been updated in job \"{$job->job_title}\". To see job details follow this link - {$job_url}"),
            'thanks' => __('Thank you for your patience!'),
        ];

        if (env('MAIL_USERNAME') && env('MAIL_PASSWORD')){
            $contact->notify(new JobAssignedToCandidates());
        }

    }

}
