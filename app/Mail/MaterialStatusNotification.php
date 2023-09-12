<?php

namespace App\Mail;

use App\Models\Material;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MaterialStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $material;
    public $status;
    /**
     * Create a new message instance.
     *
     * @param Material $material
     * @param int $status
     */
    public function __construct(Material $material, int $status)
    {
        $this->material = $material;
        $this->status = $status;
    }

    /**
     * @return DocumentStatusNotification
     *
     */
    public function build(): MaterialStatusNotification
    {
        $subject = ($this->status == 1) ? 'Material Request Accepted' : 'Material Request Rejected';

        return $this->subject($subject)
            ->view('emails.materialStatus')
            ->with([
                'material' => $this->material,
                'status' => $this->status,
            ]);
    }
}
