<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('page.contact');
    }

    public function send(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        Mail::raw($validated['message'], function ($mail) use ($validated) {
            $mail->to('bagasarif6625@gmail.com')
                ->replyTo($validated['email'], $validated['name'])
                ->subject('Pesan dari halaman Contact');
        });

        return to_route('contact')->with('success', 'Pesan kamu berhasil dikirim. Terima kasih sudah menghubungi!');
    }
}
