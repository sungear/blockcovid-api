<?php

namespace App\Services;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotificationService {
    // /** */
    //     Notifies the devices that are related to the given device tokens with
    //     a message made of the given title and body.
    //     @returns an array containing an item for each failed notification. 
    // */
    /**
     * Notifies the devices that are related to the given device tokens with
     * a message containing the given title and body.
     * 
     * @param string[] $tokens The device tokens
     * @param string $title The title of the message
     * @param string $body The body of the message
     * 
     * @return array|null The items corresponding to failed notifications, or null if none failed.
     */
    public function notifyMulticast($tokens, $title, $body) {
        // Le multicast supporte un maximum de 500 messages
        $chunks = array_chunk($tokens, 500);

        $notification = Notification::create($title, $body);
        $message = CloudMessage::new()->withNotification($notification);

        $failures = [];

        foreach($chunks as $chunkTokens) {
            $report = app('firebase.messaging')->sendMulticast($message, $chunkTokens);
            if($report->hasFailures()) {
                $chunkFailures = $report->failures()->getItems();
                array_push($failures, ...$chunkFailures);
            }
        }

        return $failures;
    }
}