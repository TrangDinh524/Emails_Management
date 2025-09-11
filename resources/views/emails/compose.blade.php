<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compose Email</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Compose Email</h1>
            <p>Send email to anyone</p>
        </div>

        <div class="content">
            @if(session('success'))
                <div class="success-message">{{ session('success') }}</div>
            @endif

            @if(session('warning'))
                <div class="warning-message">{{ session('warning') }}</div>
            @endif

            @if(session('error'))
                <div class="error-message">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="error-container">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    <ul>
                </div>
            @endif

            @if($emails->count() > 0)
                <form method="POST" action="{{ route('emails.send-bulk)}}">
                    @csrf
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input 
                            type="text"
                            id="subject"
                            name="subject"
                            class="form-input"
                            placeholder="Enter email subject"
                            required
                            value="{{ old('subject') }}"
                        >
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea 
                            id="message"
                            name="message"
                            class="form-textarea"
                            placeholder="Enter your message"
                            rows="10"
                            required
                        >{{ old('subject') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Select Recipients</label>
                        <div class="recipients-container">
                            <div class="recipients-controls">
                                <button type="button" id="select-all" class="btn btn-secondary">Select All</button>
                                <button type="button" id="deselect-all" class="btn btn-secondary">Deselect All</button>
                            </div>
                            <div class="recipients-list">
                                @foreach($emails as $email)
                                    <label class="recipient-item">
                                        <input 
                                            type="checkbox"
                                            name="recipients[]"
                                            value="{{ $emails->id }}"
                                            {{ in_array($emails->id, old('recipients', [])) ? 'checked' : '' }}
                                        >
                                        <span>{{ $emails->email }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="submit-btn" onclick="return confirm('Are you sure you want to send this email?')">Send Email</button>
                        <a href="{{ route('emails.index')}}" class="abtn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            @else
                <div class="empty-list">
                    <h3>No emails found</h3>
                    <p>You need to add some email addresses before you can send emails.</p>
                    <a href="{{ route('emails.create') }}" class="add-email-btn">
                        Add New Email
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('select-all').addEventListener('click', function(){
            const checkboxes=document.querySelectorAll('input[name="recipients[]"]');
            checkboxes.forEach(checkbox=>checkbox.checked=true)
        });
        document.getElementById('deselect-all').addEventListener('click', function(){
            const checkboxes=document.querySelectorAll('input[name="recipients[]"]');
            checkboxes.forEach(checkbox=>checkbox.checked=false)
        });
    </script>
</body>
</html>