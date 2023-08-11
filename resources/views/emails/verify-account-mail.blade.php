<!DOCTYPE html>
<html>

<head>
	<title>OTP Code Verification</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6;">
	<div style="max-width: 600px; margin: 0 auto; padding: 20px;">
		<h1>OTP Code Verification</h1>
		<p>
			Hi {{ $name }},
		</p>
		<p>
			Thank you for using our services. To verify your identity, please enter the following OTP code:
		</p>
		<div style="background-color: #f5f5f5; padding: 10px; border-radius: 5px; text-align: center; font-size: 24px;">
			<strong>{{ $otp_code }}</strong>
		</div>
		<p>
			This OTP code is valid for the next 30 minutes. Please do not share this code with anyone for security reasons.
		</p>
		<p>
			If you did not initiate this request or need assistance, please contact our support team immediately at:
			<br>
			Email: support@example.com
			<br>
			Phone: {{ $setting ? $setting->site_phone : '233 (24)842-9877' }}
		</p>
		<p>
			Thank you for choosing our services!
		</p>
		<div style="margin-top: 20px; text-align: center; color: #888;">
			<p>
				This is an automated email. Please do not reply to this message.
				<br>
				&copy; {{ date('Y') }} {{ $setting ? $setting->site_name : config('app.name') }}. All rights reserved.
			</p>
		</div>
	</div>
</body>

</html>
