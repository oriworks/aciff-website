<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Oriworks\NewsletterSystem\Models\Concerns\SystemMailable;

class Associate extends Model
{
    use HasFactory, HasUuids, SystemMailable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'social_designation',
        'address',
        'county',
        'parish',
        'zip_code',
        'locality',
        'phone',
        'fax',
        'website',
        'email',
        'nif',
        'cae',
        'legal',
        'activity',
        'joint_stock',
        'num_associates',
        'num_employees',
        'contact_name',
        'contact_job',
        'contact_phone',
        'contact_email',
        'payment_periodicity',
        'payment_type',
        'solved_at',
        'solved_by',
        'consent'
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
        self::created(function (Associate $model) {
            $systemMailModel = config('newsletter-system.models.system_mail');
            $systemMail = (new $systemMailModel)->create([
                'notification_type' => config('newsletter-system.notification-types.Associate')
            ]);
            $model->systemMail()->save($systemMail);

            Department::where('friendly_name', "ACIFF")->first()->emails->each(function ($email) use ($systemMail) {
                $systemMail
                    ->emails()
                    ->attach($email, ['priority' => 20, 'retry' => 0, 'mailable_type' => config('newsletter-system.models.system_mail')]);
            });
            $systemMail
                ->associates()
                ->attach($model, ['priority' => 20, 'retry' => 0, 'mailable_type' => config('newsletter-system.models.system_mail')]);
        });
    }

    public function solvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'solved_by');
    }
}
