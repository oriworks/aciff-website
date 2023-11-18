<?php

namespace Oriworks\NewsletterSystem\Nova\Pivots;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class MailingListNewsletterFields
{
    /**
     * Get the pivot fields for the relationship.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model  $relatedModel
     *
     * @return array
     */
    public function __invoke(NovaRequest $request, Model $relatedModel)
    {
        return [
            DateTime::make('Send at', 'send_at'),

            Text::make('Sent', function () use ($relatedModel) {
                return $this->counting($relatedModel, 'sent_at');
            }),
            Text::make('Delivered', function () use ($relatedModel) {
                return $this->counting($relatedModel, 'delivered_at');
            }),
            Text::make('Viewed', function () use ($relatedModel) {
                return $this->counting($relatedModel, 'viewed_at');
            }),
        ];
    }

    private function counting(Model $relatedModel, string $pivot)
    {
        $modelNewsletter = config('newsletter-system.models.newsletter');
        $modelMailingList = config('newsletter-system.models.mailing_list');

        $countCheckEmails = 0;
        $countEmails = 0;
        if (isset($relatedModel->pivot)) {
            $newsletter = (new $modelNewsletter)->find($relatedModel->pivot->newsletter_id);
            $mailing_list = (new $modelMailingList)->find($relatedModel->pivot->mailing_list_id);
            foreach ($newsletter->emails as $email) {
                if ($email->mailingLists->contains($mailing_list)) {
                    $countEmails++;
                    if ($email->pivot[$pivot]) {
                        $countCheckEmails++;
                    };
                }
            }
        }
        return "$countCheckEmails / $countEmails";
    }
}
