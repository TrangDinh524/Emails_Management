<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;

class EmailController extends Controller
{
    public function create()
    {
        return view('emails.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:emails,email',
        ]);

        Email::create(['email' => $request->email]);

        return redirect()->route('emails.index')->with('success', 'Email saved');
    }

    public function index()
    {
        $emails = Email::whereNull('deleted_at')->get();
        return view('emails.index', compact('emails'));
    }
}
