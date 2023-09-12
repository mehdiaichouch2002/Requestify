<?php

namespace App\Mail;
use App\Models\Vacation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VacationStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $vacation;
    public $status;
    /**
     * Create a new message instance.
     *
     * @param Vacatoin $vacation
     * @param int $status
     */
    public function __construct(Vacation $vacation, int $status)
    {
        $this->vacation = $vacation;
        $this->status = $status;
    }

    /**
     * @return VacationStatusNotification
     *
     */
    public function build(): VacationStatusNotification
    {
        $subject = ($this->status == 1) ? 'Vacation Request Accepted' : 'Vacation Request Rejected';

        return $this->subject($subject)
            ->view('emails.vacationStatus')
            ->with([
                'vacation' => $this->vacation,
                'status' => $this->status,
            ]);
    }
}
