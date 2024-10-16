<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class PushNotificationController extends Controller
{
    public function __invoke(Request $request)
    {
        // Your VAPID keys
        $publicKey = env('VAPID_PK');
        $privateKey = env('VAPID_SK');

        // Create a subscription object
        $subscription = Subscription::create([
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/fUGmTeiB4lc:APA91bFVRm6_ngyFsnTN8o5otqCgZTQ8BJtS83yPoLRYM7dekayrPI8k8wbQHVLeVInyR2wLfC-2o9d9zg_whCgEG7ClCR_iCWmW6e_P4P5fPNrBuqYPcb-3dxZhhO0HyuLWCROxoFKg',
            'keys' => [
                'p256dh' => 'BPAdpvBhf-AV51pPxzeRU4SjzM60bpkoSMpsVJXIJGXEsb9e-gzhs719jBEgYzLKeNbB-3iiWpGJjXlLi2zRKC8',
                'auth' => 'Risog1MLyZXmwRgmmWQcDg',
            ],
        ]);

        // Create a WebPush object
        $webPush = new WebPush([
            'VAPID' => [
                'subject' => 'mailto:noreply@valery.com',
                'publicKey' => $publicKey,
                'privateKey' => $privateKey,
            ],
        ]);

        // Payload of the push notification
        $payload = json_encode([
            'title' => 'Hello!',
            'body' => 'This is a test notification!',
            'icon' => '/images/emoji.png',
            'url' => 'https://www.google.com/',
        ]);

        // Send the notification
        $result = $webPush->sendOneNotification($subscription, $payload);
        if ($result->isSuccess()) {
            echo "[x] Notification sent successfully to {$result->getEndpoint()}.";
        } else {
            echo "[x] Notification failed to {$result->getEndpoint()}: {$result->getReason()}";
        }

        return new JsonResponse([]);
    }
}
