<?php

namespace Oriworks\NewsletterSystem\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

abstract class MailingListable extends Model
{
    private static $_emails = null;
    protected $mailing_lists = [];

    private static function _before(MailingListable $model): void
    {
        self::$_emails = $model->emails;
        unset($model->emails);
    }

    private static function _mailingListsIds(MailingListable $model): array
    {
        $modelMailingList = config('newsletter-system.models.mailing_list');

        $mailing_lists = [];
        foreach ($model->mailing_lists as $name) {
            $mailingListModel = (new $modelMailingList)->firstOrCreate(['name' => $name]);

            array_push($mailing_lists, $mailingListModel->id);
        }
        return $mailing_lists;
    }

    private static function _emailsIds(MailingListable $model, array $mailing_lists): array
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

    private static function _after(MailingListable $model): void
    {
        $mailing_lists = self::_mailingListsIds($model);
        $emailIds = self::_emailsIds($model, $mailing_lists);

        $model->emails()->sync($emailIds);
    }

    protected static function booted(): void
    {
        static::creating(function (MailingListable $model) {
            self::_before($model);
        });

        static::created(function (MailingListable $model) {
            self::_after($model);
        });

        static::updating(function (MailingListable $model) {
            self::_before($model);
        });

        static::updated(function (MailingListable $model) {
            self::_after($model);
        });
    }

    public function emails(): MorphToMany
    {
        return $this->morphToMany(config('newsletter-system.models.email'), 'mailing_listable');
    }
}
