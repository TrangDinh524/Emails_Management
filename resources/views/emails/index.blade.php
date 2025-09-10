<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email List</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Email Management</h1>
            <p>Manage your emails collection</p>
        </div>
        <div class="content">
            @if(session('success'))
                <div class="success-message">{{ session('success') }}</div>
            @endif
            <a href="{{ route('emails.create')}}" class="add-email-btn">
                Add New Email 
            </a>

            @if($emails->count() > 0)
                <table id="emails-table">
                    <colgroup>
                        <col style="width: 10%">
                        <col style="width: 70%">
                        <col style="width: 10%">
                        <col style="width: 10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email Address</th>
                            <th colspan="2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emails as $index=>$email)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$email->email}}</td>
                                <td>
                                    <a href="{{ route('emails.show', $email->id) }}" class="btn btn-view">View</a>
                                </td>
                                <td>
                                    <form action="{{ route('emails.destroy', $email->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="pagination">
                    {{ $emails->links() }}
                </div>

            @else
                <div class="empty-list">
                    <h3> No emails found </h3>
            @endif
        </div>
    </div>
</body>
</html>