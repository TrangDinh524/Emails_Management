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
    public function showComposeForm()
    {
        $emails = Email::whereNull('deleted_at')->get();
        return view('emails.compose', compact('emails'));
    }
    public function sendBulkEmail(Request $request)
    {
        $request->validate([
            'subject'=>'required|string|max:255',
            'message'=>'required|string',
            'recipients'=>'required|array|min:1',
            'recipients.*'=>'exists:emails,id'
        ]);

        $subject = $request->subject;
        $message = $request->message;
        $recipientIds = $request->recipients;

        $recipients = Email::whereIn('id', $recipientIds)->get();
        $sentCount = 0;
        $failedCount = 0;

        foreach($recipients as $recipient) {
            try {
                Mail::to($recipient->email)->send(new BulkEmail($subject, $message, $recipient->email));;
                $sentCount++;
                Log::info("Email sent successfully to: {$recipient->email}");
            } catch(\Exception $e) {
                $failedCount++;
                Log::error("Failed to sent message to {$recipient->email}: ".$e->getMessage());
            }
        }
        $message = "Email sending completed. Sent: {$sentCount}, Failed:{$failedCount}";
        $messageType = $failedCount > 0 ? 'warning' : 'success';
        return redirect()->route('emails.compose')->with($messageType, $message);
    }
}

