<?php

namespace Oriworks\NewsletterSystem\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class NewsletterCancellation extends Notification
{
    public function mailMessage(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Newsletter Cancellation')
            ->greeting('Até uma próxima!')
            ->line("O email **{$this->mailQueue->emailable->email}** foi cancelado com sucesso! Caso queira voltar a receber as nossas Newsletters/Comunicados verifique novamente o seu email abaixo.")
            ->action('Verificar email', route('newsletter.verify', $this->mailQueue->emailable->token));
    }
}
