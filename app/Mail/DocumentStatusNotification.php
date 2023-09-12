<?php

namespace App\Mail;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocumentStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $document;
    public $status;
    /**
     * Create a new message instance.
     *
     * @param Document $document
     * @param int $status
     */
    public function __construct(Document $document, int $status)
    {
        $this->document = $document;
        $this->status = $status;
    }

    /**
     * @return DocumentStatusNotification
     *
     */
    public function build(): DocumentStatusNotification
    {
        $subject = ($this->status == 1) ? 'Document Request Accepted' : 'Document Request Rejected';

        return $this->subject($subject)
            ->view('emails.documentStatus')
            ->with([
                'document' => $this->document,
                'status' => $this->status,
            ]);
    }
}
