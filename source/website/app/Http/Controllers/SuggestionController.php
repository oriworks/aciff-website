<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Oriworks\NewsletterSystem\Models\Email;

class SuggestionController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'department_id' => 'required',
            'subject' => 'required',
            'content' => 'required',
        ]);

        Suggestion::create($data);

        return back()->with('success', 'Registo efetuado com sucesso!');
    }

    public function solved($id, $token)
    {
        $suggestion = Suggestion::find($id);
        if (isset($suggestion)) {
            $email = Email::where('token', $token)->first();
            if (isset($email)) {
                $suggestion->solved_at = now();
                $suggestion->solved_by = $email->email;
                $suggestion->save();

                $status = __('Solved with success!');

                return redirect()->route('website.index')
                ->with('type', 'success')
                ->with('message', $status);
            } else {
                return redirect()
                ->route('website.index')
                ->with('type', 'warning')
                ->with('message', __('Email not found!'));
            }
        } else {
            return redirect()
                ->route('website.index')
                ->with('type', 'error')
                ->with('message', __('Contact not found!'));
        }
    }
}
