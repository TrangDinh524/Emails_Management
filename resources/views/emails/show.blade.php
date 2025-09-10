<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Email Details</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="small">Email Details</h1>
            <p>View email information</p>
        </div>
        <div class="content">
            <table id="details-table">
                <colgroup>
                    <col style="width: 30%">
                    <col style="width: 70%">
                </colgroup>
                <thead>
                    <tr>
                        <th>Content</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ID</td>
                        <td>{{ $email->id }}</td>
                    </tr>
                    <tr>
                        <td>Email Address</td>
                        <td> 
                            {{ $email->email }}
                            <!-- <button type="submit" class="btn btn-view" onclick="return confirm('Are you sure?')">Change Email</button> -->
                        </td>
                    </tr>
                    <tr>
                        <td>Created At</td>
                        <td>{{ $email->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Last Updated</td>
                        <td>{{ $email->updated_at->format('M d, Y \a\t g:i A')}}</td>
                    </tr>
                </tbody>
            </table>
            <div class="detail-actions">
                <a href="{{ route('emails.index') }}" class="btn btn-primary btn-large">Back to List</a>
                <form action="{{route('emails.destroy', $email->id)}}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                <button type="submit" class="btn btn-danger btn-large" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>