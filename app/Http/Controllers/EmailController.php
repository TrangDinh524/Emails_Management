<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\BulkEmail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\EmailStatistic;

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
            'attachments.*' => 'file|max:10240|mimes:pdf,doc,docx,txt,jpg,jpeg,png,gif,zip,rar',
        ]);

        $subject = $request->subject;
        $emailContent = $request->message;
        $recipientIds = $request->recipients;
        $attachmentPaths = [];

        // Handle single file upload
        if ($request->hasFile('attachments')) {
            foreach($request->file('attachments') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('attachments'), $filename);
                $attachmentPaths[] = public_path('attachments/' . $filename);
            }
        }

        $recipients = Email::whereIn('id', $recipientIds)->get();
        $sentCount = 0;
        $failedCount = 0;

        foreach($recipients as $recipient) {
            try {
                Mail::to($recipient->email)->send(new BulkEmail($subject, $emailContent, $attachmentPaths));
                $sentCount++;
                Log::info("Email sent successfully to: {$recipient->email}");
            } catch(\Exception $e) {
                $failedCount++;
                Log::error("Failed to send message to {$recipient->email}: ".$e->getMessage());
            }
        }
        
        // Track email statistic
        $this->trackEmailStatistic($sentCount, $failedCount);
      
        // Clean up uploaded file after sending
        foreach($attachmentPaths as $attachmentPath) {
            if (file_exists($attachmentPath)) {
                unlink($attachmentPath);
            }
        }
        
        $statusMessage = "Email sending completed. Sent: {$sentCount}, Failed: {$failedCount}";
        
        $messageType = $failedCount > 0 ? 'warning' : 'success';
        return redirect()->route('emails.compose')->with($messageType, $statusMessage);
    }

    private function trackEmailStatistic($sentCount, $failedCount)
    {
        try {
            $today = Carbon::today();
            $statistics = EmailStatistic::getOrCreateForDate($today);
            $statistics->increamentStats($sentCount + $failedCount, $sentCount, $failedCount);
        } catch (\Exception $e) {
            Log::error("Failed to track email statistic: " . $e->getMessage());
        }
    }
}

