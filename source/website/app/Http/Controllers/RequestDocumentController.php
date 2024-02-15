<?php

namespace App\Http\Controllers;

use App\Models\RequestDocument;
use Oriworks\NewsletterSystem\Models\Email;

class RequestDocumentController extends Controller
{public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'document_id' => 'required',
            'content' => 'required',
        ]);

        RequestDocument::create($data);

        return back()->with('success', 'Pedido efetuado com sucesso!');
    }

    public function solved($id, $token)
    {
        $suggestion = RequestDocument::find($id);
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
