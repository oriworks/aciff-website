<?php

namespace App\Http\Controllers;

use App\Models\Associate;
use Oriworks\NewsletterSystem\Models\Email;

class AssociateController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'social_designation' => 'required',
            'address' => 'required',
            'county' => 'required',
            'parish' => 'required',
            'zip_code' => 'required',
            'locality' => 'required',
            'phone' => 'required',
            'fax' => '',
            'website' => '',
            'email' => 'required|email',
            'nif' => 'required',
            'cae' => 'required',
            'legal' => 'required|in:plc,as,ip,llc',
            'activity' => 'required',
            'joint_stock' => 'required',
            'num_associates' => 'required',
            'num_employees' => 'required',
            'contact_name' => 'required',
            'contact_job' => 'required',
            'contact_phone' => 'required',
            'contact_email' => 'required|email',
            'payment_periodicity' => 'required|in:yearly,semiannual,quarterly',
            'payment_type' => 'required|in:in_store,bank_transfer',
            'consent' => 'boolean'
        ]);

        Associate::create($data);

        return back()->with('success', 'Registo efetuado com sucesso!');
    }

    public function solved($id, $token)
    {
        $associate = Associate::find($id);
        if (isset($associate)) {
            $email = Email::where('token', $token)->first();
            if (isset($email)) {
                $associate->solved_at = now();
                $associate->solved_by = $email->email;
                $associate->save();

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
                ->with('message', __('Associate not found!'));
        }
    }
}
