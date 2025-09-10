<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;
use Illuminate\Validation\Rule;

class EmailController extends Controller
{
    public function create()
    {
        return view('emails.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
                'email' => [
                    'required',
                    'email',
                    Rule::unique('emails')->whereNull('deleted_at'),
                ],
            ]);


        Email::create(['email' => $request->email]);

        return redirect()->route('emails.index')->with('success', 'Email saved');
    }

    public function index()
    {
        $emails = Email::whereNull('deleted_at')->paginate(10);
        return view('emails.index', compact('emails'));
    }
    public function show($id)
    {
        $email = Email::findOrFail($id);
        return view('emails.show', compact('email'));
    }

    public function destroy($id)
    {
        $email = Email::findOrFail($id);
        $email->delete(); // soft delete
        return redirect()->route('emails.index')->with('success', 'Email deleted!');
    }
}

