<?php

namespace App\Listeners;

use App\Events\DocumentUploadedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\GroupDocNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\DocumentUploaded;

class SendDocumentUploadedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\DocumentUploadedEvent  $event
     * @return void
     */
    

    public function handle(DocumentUploadedEvent $event)
    {
        $documentType = $event->document->id; // Assuming 'type' is mapped to 'document_id' in your table

        // Fetch the groups that need to be notified for this document type
        $notifiableGroups = GroupDocNotification::where('document_id', $documentType)
                                                ->pluck('group_id');

        foreach ($notifiableGroups as $groupId) {
            // Fetch all users in the group
            $groupUsers = User::where('user_group_id', $groupId)->get();

            // Send an email notification to each user in the group
            foreach ($groupUsers as $user) {
                Mail::to($user->email)->send(new DocumentUploaded($event->document));
            }
        }
    }


}
