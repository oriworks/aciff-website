<?php

namespace Oriworks\NewsletterSystem\Http\Controllers;

use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function signup(Request $request)
    {
        $emailModel = config('newsletter-system.models.email');

        $request->validate([
            'email' => 'required|email|unique:emails,email'
        ]);

        (new $emailModel)->create(['email' => $request->email]);

        return response()->json(['success' => 'Form is successfully submitted!']);
    }

    public function verify($token)
    {
        $emailModel = config('newsletter-system.models.email');
        $email = (new $emailModel)->where('token', $token)->first();
        if (isset($email)) {
            if (!$email->verified_at) {
                $email->canceled_at = null;
                $email->verified_at = now();
                $email->save();
                $status = 'Email verify with success!';
            } else {
                $status = 'Email already has verify!';
            }
        } else {
            return redirect()
                ->route(config('newsletter-system.redirect_route'))
                ->with('type', 'warning')
                ->with('message', 'Email not found!');
        }
        return redirect()->route(config('newsletter-system.redirect_route'))
            ->with('type', 'success')
            ->with('message', $status);
    }

    public function cancel($token)
    {
        $emailModel = config('newsletter-system.models.email');
        $email = (new $emailModel)->where('token', $token)->first();
        if (isset($email)) {
            if (!$email->canceled_at) {
                $email->verified_at = null;
                $email->canceled_at = now();
                $email->save();
                $status = 'Email cancelado com sucesso!';
                $newsletterModel = config('newsletter-system.models.newsletter');
                $systemMailModel = config('newsletter-system.models.system_mail');
                (new $newsletterModel)->firstOrCreate([
                    'newsletterable_type' => config('newsletter-system.models.system_mail'),
                    'newsletterable_id' => (new $systemMailModel)->firstOrCreate([
                        'notification_type' => config('newsletter-system.notification-types.NewsletterCancellation')
                    ])->id,
                ])
                    ->emails()
                    ->syncWithoutDetaching([$email->id]);
            } else {
                $status = 'Email já tinha sido cancelado.';
            }
        } else {
            return redirect()
                ->route(config('newsletter-system.redirect_route'))
                ->with('type', 'warning')
                ->with('message', 'Email não encontrado');
        }
        return redirect()
            ->route(config('newsletter-system.redirect_route'))
            ->with('type', 'success')
            ->with('message', $status);
    }
}
