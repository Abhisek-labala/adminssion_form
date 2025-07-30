<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable; // 👈 Required for dispatch()
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\AdmissionRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdmissionRequestMail;

class SendAdmissionRequestEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels; // ✅ Include Dispatchable here

    protected $admissionRequest;

    public function __construct(AdmissionRequest $admissionRequest)
    {
        $this->admissionRequest = $admissionRequest;
    }

    public function handle()
    {
        try {
            Mail::to($this->admissionRequest->patient_email)->send(new AdmissionRequestMail($this->admissionRequest));
            $this->admissionRequest->update(['email_sent' => true]);

        } catch (\Exception $e) {
            \Log::error("Email failed for admission ID {$this->admissionRequest->id}: {$e->getMessage()}");
        }
    }
}
