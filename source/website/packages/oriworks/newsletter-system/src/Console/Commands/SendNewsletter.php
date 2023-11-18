<?php

namespace Oriworks\NewsletterSystem\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send N emails from queue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $num_emails_to_send = config('newsletter-system.num_emails_to_send');
        $mailQueueModel = config('newsletter-system.models.mail_queue');
        (new $mailQueueModel)->whereNull('sent_at')
            ->where(function ($query) {
                $query->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('mailing_list_newsletter')
                        ->where('mailing_list_newsletter.send_at', '<=', Carbon::now())
                        ->join('email_mailing_list', 'email_mailing_list.mailing_list_id', '=', 'mailing_list_newsletter.mailing_list_id')
                        ->whereColumn('email_mailing_list.email_id', 'mail_queues.emailable_id')
                        ->whereColumn('mailing_list_newsletter.newsletter_id', 'mail_queues.mailable_id');
                })->orWhereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('system_mails')
                        ->whereColumn('system_mails.id', 'mail_queues.mailable_id');
                });
            })
            ->orderByDesc('priority')
            ->limit($num_emails_to_send)
            ->get()
            ->each(function ($item, $key) {
                $notification_type = $item->mailable->notification_type;
                $item->emailable->notify((new $notification_type($item)));
                $this->info("Send {$notification_type} to {$item->emailable->email}");
                try {
                } catch (\Throwable $th) {
                    $this->error("Não enviado");
                }
            });

        return 0;
    }
}
