<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $details['mail_type'] }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
<table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto; background-color: #ffffff; border: 1px solid #365CCE; border-radius: 6px;">
    <tr>
        <td style="padding: 20px; text-align: center;">
            <svg width="32" height="32" viewBox="0 0 36 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_508_444)">
                    <path d="M35.9502 19.8193H29.5201C23.9033 19.8193 19.3501 24.3726 19.3501 29.9893V36.4195C28.215 35.7621 35.2929 28.6842 35.9502 19.8193Z" fill="#704FE6"/>
                    <path d="M16.6505 36.4195V29.9893C16.6505 24.3726 12.0972 19.8193 6.48043 19.8193H0.050293C0.707594 28.6842 7.78552 35.7621 16.6505 36.4195Z" fill="#704FE6"/>
                    <path d="M35.9502 17.1197C35.2929 8.25476 28.215 1.17683 19.3501 0.519531V6.94967C19.3501 12.5664 23.9033 17.1197 29.5201 17.1197H35.9502Z" fill="#704FE6"/>
                    <path d="M16.6505 0.519531C7.78552 1.17683 0.707594 8.25476 0.050293 17.1197H6.48043C12.0972 17.1197 16.6505 12.5664 16.6505 6.94967V0.519531Z" fill="#704FE6"/>
                    <path d="M12.2246 18.4699C14.7199 17.2231 16.7534 15.1896 18.0001 12.6943C19.2469 15.1896 21.2803 17.2231 23.7757 18.4699C21.2803 19.7166 19.2469 21.7501 18.0001 24.2454C16.7534 21.7501 14.7199 19.7166 12.2246 18.4699Z" fill="#FFD25D"/>
                </g>
                <defs>
                    <clipPath id="clip0_508_444">
                        <rect width="36" height="36" fill="white" transform="translate(0 0.469727)"/>
                    </clipPath>
                </defs>
            </svg>
            <h1 style="margin: 0; color: #333;">GrandLibrary</h1>
        </td>
    </tr>
    <tr>
        <td style="background-color: #365CCE; height: 2px;"></td>
    </tr>
    <tr>
        <td style="padding: 20px; text-align: center;">
            <h2 style="margin-bottom: 10px;">{{ $details['mail_type'] }}</h2>
            <p style="font-size: 16px; color: #333;">Hello, <strong>{{ $details['recipient_name'] }}</strong></p>
            <p style="font-size: 16px; color: #333; white-space: pre-line;">{{ $details['message'] }}</p>
            <p style="margin-top: 30px; font-size: 14px; color: #888;">
                Thank you,<br>
                GrandLibrary Admin
            </p>
        </td>
    </tr>
</table>
</body>
</html>
