<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocumentUploaded extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $document;
    public function __construct($document)
    {
        $this->document = $document;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@example.com')
                    ->subject('New Document Uploaded')
                    ->view('emails.document_uploaded')
                    ->with([
                        'documentName' => $this->document->doc_type_name,
                        /*'documentType' => $this->document->type,
                        'uploader' => $this->document->uploaded_by, // Assuming you have an 'uploaded_by' field
                        'description' => $this->document->description, // Assuming you have a 'description' field*/
                    ]);
    }
}
