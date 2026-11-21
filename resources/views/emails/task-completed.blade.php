<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task completed</title>
</head>
<body style="margin:0; padding:0; background:#f5f5f7; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif; color:#1d1d1f;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f7; padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:520px; background:#ffffff; border-radius:18px; padding:32px 28px;">
                    <tr>
                        <td>
                            <p style="margin:0 0 8px; font-size:14px; color:#248a3d; font-weight:600;">Task completed</p>
                            <h1 style="margin:0 0 16px; font-size:24px; line-height:1.2; font-weight:600;">{{ $task->title }}</h1>
                            <p style="margin:0 0 24px; font-size:16px; line-height:1.5; color:#6e6e73;">
                                This task was just marked as done in Tasks for Today.
                            </p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:15px; border-top:1px solid #e8e8ed;">
                                <tr>
                                    <td style="padding:12px 0; color:#6e6e73;">Scheduled for</td>
                                    <td style="padding:12px 0; text-align:right;">{{ $task->task_date->format('l, F j, Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0; color:#6e6e73; border-top:1px solid #e8e8ed;">Completed</td>
                                    <td style="padding:12px 0; text-align:right; border-top:1px solid #e8e8ed;">{{ $task->updated_at->format('F j, Y g:i A') }}</td>
                                </tr>
                            </table>
                            <p style="margin:24px 0 0;">
                                <a href="{{ route('tasks.index') }}" style="display:inline-block; background:#0071e3; color:#ffffff; text-decoration:none; padding:10px 20px; border-radius:980px; font-size:15px;">View Task List</a>
                            </p>
                        </td>
                    </tr>
                </table>
                <p style="margin:16px 0 0; font-size:12px; color:#86868b;">Tasks for Today Management System</p>
            </td>
        </tr>
    </table>
</body>
</html>
