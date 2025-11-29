<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Submitted</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            color: #374151;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #e75500 0%, #ff8c42 100%);
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #111827;
        }
        .message {
            line-height: 1.6;
            color: #4b5563;
            margin-bottom: 30px;
        }
        .ticket-info {
            background-color: #fff7ed;
            border: 1px solid #ffedd5;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #9a3412;
            font-weight: 700;
            letter-spacing: 0.05em;
        }
        .info-value {
            font-size: 16px;
            color: #1f2937;
            font-weight: 500;
        }
        .button-container {
            text-align: center;
            margin-top: 30px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #e75500 0%, #ff8c42 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            transition: opacity 0.3s;
        }
        .button:hover {
            opacity: 0.9;
        }
        .footer {
            text-align: center;
            padding: 30px;
            color: #9ca3af;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>Support Desk</h1>
            </div>
            <div class="content">
                <p class="greeting">Hello {{ $ticket->full_name }},</p>
                <p class="message">
                    Thank you for contacting us. We have received your support ticket and our team will review it shortly. Here are the details of your submission:
                </p>
                
                <div class="ticket-info">
                    <div class="info-item">
                        <div class="info-label">Ticket Reference</div>
                        <div class="info-value" style="font-family: monospace; font-size: 18px; color: #ea580c;">{{ $ticket->ticket_ref }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Subject</div>
                        <div class="info-value">{{ $ticket->subject }}</div>
                    </div>
                    <div class="info-item" style="margin-bottom: 0;">
                        <div class="info-label">Type</div>
                        <div class="info-value">{{ $ticket->ticket_type }}</div>
                    </div>
                </div>

                <p class="message">
                    You can check the status of your ticket at any time using the reference number above.
                </p>

                <div class="button-container">
                    <a href="{{ route('ticket.status.form') }}" class="button">Check Ticket Status</a>
                </div>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Support Desk. All rights reserved.<br>
            If you did not submit this ticket, please ignore this email.
        </div>
    </div>
</body>
</html>
