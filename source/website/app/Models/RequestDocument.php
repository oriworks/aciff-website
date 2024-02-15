<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Oriworks\NewsletterSystem\Models\Concerns\SystemMailable;

class RequestDocument extends Model
{
    use HasFactory, HasUuids, SystemMailable, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'document_id',
        'content',
        'solved_at',
        'solved_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'solved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function booted()
    {
        self::created(function (RequestDocument $model) {
            $systemMailModel = config('newsletter-system.models.system_mail');
            $systemMail = (new $systemMailModel)->create([
                'notification_type' => config('newsletter-system.notification-types.RequestDocument')
            ]);
            $model->systemMail()->save($systemMail);

            Department::firstWhere('name', 'História')->emails->each(function ($email) use ($systemMail) {
                $systemMail
                    ->emails()
                    ->attach($email, ['priority' => 20, 'retry' => 0, 'mailable_type' => config('newsletter-system.models.system_mail')]);
            });
            $systemMail
                ->requestDocuments()
                ->attach($model, ['priority' => 20, 'retry' => 0, 'mailable_type' => config('newsletter-system.models.system_mail')]);
        });
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

}
