<?php

namespace Oriworks\NewsletterSystem\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class NewsletterSignUp extends Notification
{
    public function mailMessage(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Newsletter Sign Up')
            ->greeting('Seja em vindo(a)!')
            ->line("O seu email **{$this->mailQueue->emailable->email}** foi registado com sucesso! Para começar a receber as nossas Newsletters/Comunicados verifique o seu email abaixo.")
            ->action('Verificar email', route('newsletter.verify', $this->mailQueue->emailable->token));
    }
}

