<?php

namespace Oriworks\NewsletterSystem\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification as IlluminateNotification;
use Oriworks\NewsletterSystem\Models\Pivots\MailQueue;
use Symfony\Component\Mime\Email;

abstract class Notification extends IlluminateNotification implements HasMailMessage
{
    protected MailQueue $mailQueue;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(MailQueue $mailQueue)
    {
        $this->mailQueue = $mailQueue;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return $this->mailMessage($notifiable)->withSymfonyMessage(function (Email $message) {
            $message->getHeaders()->addTextHeader('X-Emailable-Type', $this->mailQueue->emailable_type);
            $message->getHeaders()->addTextHeader('X-Emailable-Id', $this->mailQueue->emailable_id);
            $message->getHeaders()->addTextHeader('X-Mailable-Type', $this->mailQueue->mailable_type);
            $message->getHeaders()->addTextHeader('X-Mailable-Id', $this->mailQueue->mailable_id);
        });
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
