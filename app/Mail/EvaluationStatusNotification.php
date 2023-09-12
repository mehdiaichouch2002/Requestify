<?php

namespace App\Mail;


use App\Models\Evaluation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EvaluationStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $evaluation;
    public $status;
    /**
     * Create a new message instance.
     *
     * @param Evaluation $evaluation
     * @param int $status
     */
    public function __construct(Evaluation $evaluation, int $status)
    {
        $this->evaluation = $evaluation;
        $this->status = $status;
    }

    public function build(): EvaluationStatusNotification
    {
        $subject = ($this->status == 1) ? 'Evaluation Request Accepted' : 'Evaluation Request Rejected';

        return $this->subject($subject)
            ->view('emails.evaluationStatus')
            ->with([
                'evaluation' => $this->evaluation,
                'status' => $this->status,
            ]);
    }
}
