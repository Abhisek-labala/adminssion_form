<?php

namespace App\Mail;

use App\Models\AdmissionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use PDF;

class AdmissionRequestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $admission;

    public function __construct(AdmissionRequest $admission)
    {
        $this->admission = $admission;
    }

    public function build()
    {
        // Generate the PDF
        $pdf = PDF::loadView('pdf.admission_request', ['admission' => $this->admission]);

        return $this->subject('Your Admission Request Details')
                    ->markdown('emails.admission.request')
                    ->attachData($pdf->output(), 'AdmissionRequest.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
