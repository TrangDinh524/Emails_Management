<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\BulkEmail;
use Illuminate\Support\Facades\Log;

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
            'recipients.*'=>'exists:emails,id',
            'attachments.*'=>'file|max:10240|mimes:pdf,doc,docx,txt,jpg,jpeg,png,gif,zip,rar',
        ]);

        $subject = $request->subject;
        $emailContent = $request->message;
        $recipientIds = $request->recipients;
        $attachments = [];

        if ($request->hasFile('attachments')) {
            foreach($request->file('attachments') as $file) {
                $filename = time().'_'.$file->getClientOriginalName();
                $path = $file->storeAs('email_attachments', $filename, 'public');

                $attachments[] = [
                    'path'=>storage_path('app/public/'.$path),
                    'name'=>$file->getClientOriginalName(),
                    'mime'=>$file->getMimeType()
                ];
            }
        }

        $recipients = Email::whereIn('id', $recipientIds)->get();
        $sentCount = 0;
        $failedCount = 0;

        foreach($recipients as $recipient) {
            try {
                Mail::to($recipient->email)->send(new BulkEmail($subject, $emailContent, $attachments));
                $sentCount++;
                Log::info("Email sent successfully to: {$recipient->email}");
            } catch(\Exception $e) {
                $failedCount++;
                Log::error("Failed to sent message to {$recipient->email}: ".$e->getMessage());
            }
        }
        // Clean up uploaded files after sending
        foreach ($attachments as $attachment) {
            if (file_exists($attachment['path'])) {
                unlink($attachment['path']);
            }
        }
        $statusMessage = "Email sending completed. Sent: {$sentCount}, Failed:{$failedCount}";
        $messageType = $failedCount > 0 ? 'warning' : 'success';
        return redirect()->route('emails.compose')->with($messageType, $statusMessage);
    }
}

