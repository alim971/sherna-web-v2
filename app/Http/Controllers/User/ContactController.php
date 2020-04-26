<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessage;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Zobraz kontaktní formulář.
     *
     * @return Factory|View
     */
    public function show()
    {
        return view('client.contact.show');
    }

    /**
     * Zpracuj kontaktní formulář a odešli email.
     *
     * @param ContactRequest $request
     * @return RedirectResponse
     */
    public function send(ContactRequest $request)
    {
        Mail::to(env('MAIL_TO'))->send(new ContactMessage($request->input('email'), $request->input('message')));

        return redirect()->route('contact.show');
    }
}
