<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Email Detail</title>
</head>
<body>
    <h1>Email Details</h1>
    <p><strong>ID:</strong> {{ $email->id }}</p>
    <p><strong>Email:</strong> {{ $email->email }}</p>
    <p><strong>Created At:</strong> {{ $email->created_at }}</p>
    <p><strong>Updated At:</strong> {{ $email->updated_at }}</p>

    <a href="{{ route('emails.index') }}">Back to List</a>
</body>
</html>