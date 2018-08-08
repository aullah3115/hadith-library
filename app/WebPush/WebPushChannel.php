<?php

namespace App\WebPush;

use Minishlink\WebPush\WebPush;
use Illuminate\Notifications\Notification;
use Minishlink\WebPush\Subscription;

class WebPushChannel
{
    /** @var \Minishlink\WebPush\WebPush */
    protected $webPush;

    /**
     * @param  \Minishlink\WebPush\WebPush $webPush
     * @return void
     */
    public function __construct(WebPush $webPush)
    {
        $this->webPush = $webPush;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $subscriptions = $notifiable->routeNotificationFor('WebPush');

        if ($subscriptions->isEmpty()) {
            return;
        }

        $payload = json_encode($notification->toWebPush($notifiable, $notification)->toArray());

        

        $subscriptions->each(function ($sub) use ($payload) {

            $subscription = Subscription::create([
                'endpoint' => $sub->endpoint, 
                'publicKey' => $sub->public_key, 
                'authToken' => $sub->auth_token,
            ]);

            $this->webPush->sendNotification(
                $subscription,
                $payload
            );
        });

        $response = $this->webPush->flush();
        return 'hey';

        $this->deleteInvalidSubscriptions($response, $subscriptions);
    }

    /**
     * @param  array|bool $response
     * @param  \Illuminate\Database\Eloquent\Collection $subscriptions
     * @return void
     */
    protected function deleteInvalidSubscriptions($response, $subscriptions)
    {
        if (! is_array($response)) {
            return;
        }

        foreach ($response as $index => $value) {
            if (! $value['success'] && isset($subscriptions[$index])) {
                $subscriptions[$index]->delete();
            }
        }
    }
}
