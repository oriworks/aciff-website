<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Role::class => \App\Policies\RolePolicy::class,
        \App\Models\Permission::class => \App\Policies\PermissionPolicy::class,
        \App\Models\Category::class => \App\Policies\CategoryPolicy::class,
        \App\Models\Document::class => \App\Policies\DocumentPolicy::class,
        \App\Models\Tag::class => \App\Policies\TagPolicy::class,
        \App\Models\Entity::class => \App\Policies\EntityPolicy::class,
        \App\Models\Department::class => \App\Policies\DepartmentPolicy::class,
        \App\Models\Associate::class => \App\Policies\AssociatePolicy::class,
        \App\Models\Banner::class => \App\Policies\BannerPolicy::class,
        \App\Models\Keyword::class => \App\Policies\KeywordPolicy::class,
        \Oriworks\NewsletterSystem\Models\Email::class => \App\Policies\EmailPolicy::class,
        \Oriworks\NewsletterSystem\Models\MailingList::class => \App\Policies\MailingListPolicy::class,
        \Oriworks\NewsletterSystem\Models\Newsletter::class => \App\Policies\NewsletterPolicy::class,
        \Oriworks\NewsletterSystem\Models\Sender::class => \App\Policies\SenderPolicy::class,
        \App\Models\SystemMail::class => \App\Policies\SystemMailPolicy::class,
        \Oriworks\NewsletterSystem\Models\Pivots\MailQueue::class => \App\Policies\MailQueuePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });
    }
}
