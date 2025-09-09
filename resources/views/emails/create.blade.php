<!DOCTYPE html>
<html>
<head>
    <title>Submit Email</title>
</head>
<body>
    <h1>Enter Email</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('emails.store') }}">
        @csrf
        <input type="email" name="email" placeholder="Enter email" required>
       <button type="submit">Submit</button>
    </form>
</body>
</html>
