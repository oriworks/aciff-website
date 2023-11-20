<?php

namespace Oriworks\NewsletterSystem\Models\Concerns;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait MailingListableTrait
{
    private static $_emails = null;

    protected static function _before($model): void
    {
        self::$_emails = $model->emails;
        unset($model->emails);
    }

    protected static function _mailingListsIds($model): array
    {
        $modelMailingList = config('newsletter-system.models.mailing_list');

        $mailing_lists = [];
        foreach ($model->mailing_lists as $name) {
            $mailingListModel = (new $modelMailingList)->firstOrCreate(['name' => $name]);

            array_push($mailing_lists, $mailingListModel->id);
        }
        return $mailing_lists;
    }

    protected static function _emailsIds($model, array $mailing_lists): array
    {
        $modelEmail = config('newsletter-system.models.email');

        $emailIds = [];
        foreach (self::$_emails as $email) {
            $emailModel = (new $modelEmail)->firstOrCreate(['email' => is_string($email) ? $email : $email->email]);

            $emailModel->mailingLists()->syncWithoutDetaching($mailing_lists);

            array_push($emailIds, $emailModel->id);
        }

        return $emailIds;
    }

    protected static function _after($model): void
    {
        $mailing_lists = self::_mailingListsIds($model);
        $emailIds = self::_emailsIds($model, $mailing_lists);

        $model->emails()->sync($emailIds);
    }

    protected static function bootMailingListableTrait()
    {
        static::creating(function ($model) {
            self::_before($model);
        });

        static::created(function ($model) {
            self::_after($model);
        });

        static::updating(function ($model) {
            self::_before($model);
        });

        static::updated(function ($model) {
            self::_after($model);
        });
    }

    public function emails(): MorphToMany
    {
        return $this->morphToMany(config('newsletter-system.models.email'), 'mailing_listable');
    }
}
