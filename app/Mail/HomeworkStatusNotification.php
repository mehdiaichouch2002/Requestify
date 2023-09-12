<?php

namespace App\Mail;

use App\Models\Homework;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HomeworkStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $homework;
    public $status;
    /**
     * Create a new message instance.
     *
     * @param Homework $homework
     * @param int $status
     */
    public function __construct(Homework $homework, int $status)
    {
        $this->homework = $homework;
        $this->status = $status;
    }

    /**
     * @return HomeworkStatusNotification
     *
     */
    public function build(): HomeworkStatusNotification
    {
        $subject = ($this->status == 1) ? 'Homework Request Accepted' : 'Homework Request Rejected';

        return $this->subject($subject)
            ->view('emails.homeworkStatus')
            ->with([
                'homework' => $this->homework,
                'status' => $this->status,
            ]);
    }
}
