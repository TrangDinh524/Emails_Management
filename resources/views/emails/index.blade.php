<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email List</title>
</head>
<body>
    <h1>Email List</h1>
    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif
    <ul>
        @foreach ($emails as $email)
            <li>{{ $email->email }}</li>
            <a href="{{ route('emails.show', $email->id) }}">View</a>

            <form action="{{ route('emails.destroy', $email->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
            </form>

        @endforeach
    </ul>
   
</body>
</html>