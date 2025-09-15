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
                <form method="POST" action="{{ route('emails.send-email')}}" enctype="multipart/form-data">
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
                        >{{ old('message') }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="attachments">Attachments (Optional)</label>
                        <input 
                            type="file"
                            id="attachments"
                            name="attachments[]"
                            class="form-input"
                            multiple
                            accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png,.gif,.zip,.rar"
                        >
                        <small class="form-help">
                            You can select multiple files. Maximum file size: 10MB per file. Allowed types: PDF, DOC, DOCX, TXT, JPG, JPEG, PNG, GIF, ZIP, RAR
                        </small>
                        <div id="file-list" class="file-list"></div>
                    </div>

                    <div class="form-group">
                        <label>Select Recipients</label>
                        <div class="recipients-container">
                            <div class="recipients-controls">
                                <button type="button" id="select-all" class="btn btn-secondary btn-view">Select All</button>
                                <button type="button" id="deselect-all" class="btn btn-secondary btn-danger">Deselect All</button>
                            </div>
                            <div class="recipients-list">
                                @foreach($emails as $email)
                                    <label class="recipient-item">
                                        <input 
                                            type="checkbox"
                                            name="recipients[]"
                                            value="{{ $email->id }}"
                                            {{ in_array($email->id, old('recipients', [])) ? 'checked' : '' }}
                                        >
                                        <span>{{ $email->email }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="mt-3">
                            <button type="submit" formaction="{{ route('emails.send-email') }}" class="btn btn-primary">Send Emails (Queued)</button>
                            <button type="submit" formaction="{{ route('emails.send-email-immediate') }}" class="btn btn-warning">Send Emails (Immediate)</button>
                            <a href="{{ route('emails.queue-status') }}" class="btn btn-info">View Queue Status</a>
                        </div>
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
        
        // Show file list when files are selected
        document.getElementById('attachments').addEventListener('change', function(e){
            const fileList = document.getElementById('file-list');
            fileList.innerHTML = '';
            
            if (e.target.files.length > 0) {
                const fileListTitle = document.createElement('h4');
                fileListTitle.textContent = 'Selected Files:';
                fileList.appendChild(fileListTitle);
                
                Array.from(e.target.files).forEach((file, index) => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item';
                    fileItem.innerHTML = `
                        <span class="file-name">${file.name}</span>
                        <span class="file-size">(${(file.size / 1024 / 1024).toFixed(2)} MB)</span>
                    `;
                    fileList.appendChild(fileItem);
                });
            }
        });
    </script>
</body>
</html>