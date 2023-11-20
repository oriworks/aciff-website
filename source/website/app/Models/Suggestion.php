<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Oriworks\NewsletterSystem\Models\Concerns\SystemMailable;

class Suggestion extends Model
{
    use HasFactory, HasUuids, SystemMailable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'department_id',
        'subject',
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
        self::created(function (Suggestion $model) {
            $systemMailModel = config('newsletter-system.models.system_mail');
            $systemMail = (new $systemMailModel)->create([
                'notification_type' => config('newsletter-system.notification-types.Suggestion')
            ]);
            $model->systemMail()->save($systemMail);

            $model->department->emails->each(function ($email) use ($systemMail) {
                $systemMail
                    ->emails()
                    ->attach($email, ['priority' => 20, 'retry' => 0, 'mailable_type' => config('newsletter-system.models.system_mail')]);
            });
            $systemMail
                ->suggestions()
                ->attach($model, ['priority' => 20, 'retry' => 0, 'mailable_type' => config('newsletter-system.models.system_mail')]);
        });
    }

    /**
     * Get the department for the suggestion.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function solvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'solved_by');
    }
}
