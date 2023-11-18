<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Oriworks\NewsletterSystem\Notifications\Notification;

class WelcomeNewWebsite extends Notification
{
    /**
     * Get the mail representation of the notification.
     */
    public function mailMessage(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome new website')
            ->greeting('Novo site da ACIFF!')
            ->line("Temos o prazer de anunciar que renovamos o nosso site!")
            ->line("O seu email **{$this->mailQueue->emailable->email}** já se encontrava registado no antigo site. Para continuar a receber as nossas Newsletters/Comunicados verifique o seu email abaixo.")
            ->action('Verificar email', route('newsletter.verify', $this->mailQueue->emailable->token))
            ->line("Ou caso não pretenda receber mais nenhum dos nossos conteúdos por-favor cancele a subscrição para que não enviemos outros emails para si.")
            ->action('Cancelar subscrição', route('newsletter.cancel', $this->mailQueue->emailable->token))
            ->salutation("Com cumprimentos,\nDa equipa Aciff");
    }
}
