<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Queue Status</title>
    <meta http-equiv="refresh" content="10">
</head>
<body>
    <div class="auto-refresh">Auto-refresh: 10s</div>
    
    <div class="container">
        <h1>📧 Email Queue Status</h1>
        
        <!-- Queue Statistics -->
        <div class="stats-grid">
            <div class="stat-card pending">
                <div class="stat-title">Pending</div>
                <div class="stat-number">{{ $queueStats['pending'] }}</div>
            </div>
            <div class="stat-card processing">
                <div class="stat-title">Processing</div>
                <div class="stat-number">{{ $queueStats['processing'] }}</div>
            </div>
            <div class="stat-card sent">
                <div class="stat-title">Sent</div>
                <div class="stat-number">{{ $queueStats['sent'] }}</div>
            </div>
            <div class="stat-card failed">
                <div class="stat-title">Failed</div>
                <div class="stat-number">{{ $queueStats['failed'] }}</div>
            </div>
        </div>

        <!-- Recent Emails Table -->
        <div class="table-container">
            <div class="table-header">
                <h3>Recent Email Activity</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Email Address</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Processed</th>
                        <th>Error</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentEmails as $emailQueue)
                    <tr>
                        <td>{{ $emailQueue->email->email }}</td>
                        <td>{{ Str::limit($emailQueue->subject, 40) }}</td>
                        <td>
                            <span class="status-badge status-{{ $emailQueue->status }}">
                                {{ ucfirst($emailQueue->status) }}
                            </span>
                        </td>
                        <td>{{ $emailQueue->created_at->format('M j, H:i') }}</td>
                        <td>{{ $emailQueue->processed_at ? $emailQueue->processed_at->format('M j, H:i') : '-' }}</td>
                        <td>{{ $emailQueue->error_message ? Str::limit($emailQueue->error_message, 30) : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            No emails in queue
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Action Buttons -->
        <div class="actions">
            <a href="{{ route('emails.compose') }}" class="btn btn-primary">Compose Email</a>
            <a href="{{ route('emails.index') }}" class="btn btn-secondary">Email List</a>
        </div>
    </div>
</body>
</html>