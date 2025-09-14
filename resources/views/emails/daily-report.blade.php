<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daily Email Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .stats-container {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .stat-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .stat-item:last-child {
            border-bottom: none;
        }
        .stat-label {
            font-weight: bold;
        }
        .stat-value {
            font-weight: bold;
        }
        .success-rate {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
            text-align: center;
        }
        .footer {
            text-align: center;
            color: #6c757d;
            font-size: 12px;
            margin-top: 30px;
        }
        .timezone-info {
            background-color: #e3f2fd;
            color: #1565c0;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daily Email Report</h1>
        <p><strong>Date:</strong> {{ $date->format('F j, Y') }}</p>
        <div class="timezone-info">
            <strong>Report Time:</strong> 5:00 PM (Hanoi Time)
        </div>
    </div>

    <div class="stats-container">
        <h2>Today's Email Statistics</h2>
        
        <div class="stat-item">
            <span class="stat-label">Total Emails Sent: </span>
            <span class="stat-value">{{ $statistics->total_emails_sent }}</span>
        </div>
        
        <div class="stat-item">
            <span class="stat-label">Successful Emails: </span>
            <span class="stat-value">{{ $statistics->successful_emails }}</span>
        </div>
        
        <div class="stat-item">
            <span class="stat-label">Failed Emails: </span>
            <span class="stat-value">{{ $statistics->failed_emails }}</span>
        </div>
    </div>

    <div class="footer">
        <p>This is an automated daily report from your Email Management System.</p>
    </div>
</body>
</html>