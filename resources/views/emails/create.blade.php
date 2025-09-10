<!DOCTYPE html>
<html>
<head>
    <!-- <meta charset="UTF-8"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Email</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Email Management</h1>
            <p>Add new email</p>
        </div>
        <div class="content">
            <div class="login-container">
                <div class="login-header">
                    <h1>Add New Email</h1>
                    <p>Enter an email address to add to your collection</p>
                </div>

                @if ($errors->any())
                    <div class="error-container">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('emails.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input 
                            type="email" 
                            id="email"
                            name="email" 
                            class="form-input"
                            placeholder="Enter email address" 
                            required
                            value="{{ old('email') }}"
                        >
                    </div>
                    
                    <button type="submit" class="submit-btn">
                        Add Email
                    </button>
                </form>

                <a href="{{ route('emails.index') }}" class="back-link">
                    Back to Email List
                </a>
        </div>
    </div>
</body>
</html>
