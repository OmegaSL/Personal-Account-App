<!DOCTYPE html>
<html>

<head>
	<title>Transaction Status Email</title>

	<style>
		.bg_success_color {
			background-color: #b5f5d2;
			padding: 20px;
			border-radius: 5px;
		}

		.bg_danger_color {
			background-color: #f5c5c5;
			padding: 20px;
			border-radius: 5px;
		}

		.bg_warning_color {
			background-color: #f7f1c0;
			padding: 20px;
			border-radius: 5px;
		}

		.text_success_color {
			color: #1dca6b;
		}

		.text_danger_color {
			color: #ff4d4f;
		}

		.text_warning_color {
			color: #ffec3d;
		}

		.text_white_color {
			color: #fff;
		}
	</style>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6;">
	<div style="max-width: 600px; margin: 0 auto; padding: 20px;">
		<h1>Transaction Status Notification</h1>

		<!-- Completed Section -->
		<div
			class="{{ $transaction->status == 'completed' ? 'bg_success_color' : ($transaction->status == 'cancelled' || $transaction->status == 'failed' ? 'bg_danger_color' : 'bg_warning_color') }}">
			<h2
				class="{{ $transaction->status == 'completed' ? 'text_success_color' : ($transaction->status == 'cancelled' || $transaction->status == 'failed' ? 'text_danger_color' : 'text_warning_color') }}">
				Status: {{ Str::title($transaction->status) }}
			</h2>
			<p>
				Dear {{ $transaction->user->name }},
			</p>
			<p>
				@if ($transaction->status == 'cancelled' || $transaction->status == 'failed')
					We regret to inform you that your transaction has been cancelled.
				@else
					We are pleased to inform you that your transaction is {{ $transaction->status }}.
				@endif
			</p>
			<p>
				Transaction ID: {{ $transaction->reference }}
				<br>
				Amount: {{ $setting->currency }}{{ $transaction->amount }}
				<br>
				Date: {{ $transaction->created_at->format('d M, Y') }}
			</p>
			<p>
				@if ($transaction->status == 'cancelled' || $transaction->status == 'failed')
					If you believe this cancellation is a mistake or need further assistance, please don't hesitate to contact us at:
				@else
					If you have any questions or need further assistance, please don't hesitate to contact us at:
				@endif
				<br>
				Email: {{ $setting->site_email ?? 'Not Provided' }} <br>
				Alternative Email: {{ $setting->site_email2 ?? 'Not Provided' }}
				<br>
				Contact: {{ $setting->site_phone ?? 'Not Provided' }} <br>
				Alternative Contact: {{ $setting->site_phone2 ?? 'Not Provided' }}
			</p>
			<p>
				Thank you for choosing our service!
			</p>
		</div>

		{{-- <!-- Cancelled Section -->
		<div style="background-color: #f8e0e0; padding: 20px; border-radius: 5px; margin-top: 20px;">
			<h2 style="color: #c0392b;">Status: Cancelled</h2>
			<p>
				Dear [Customer Name],
			</p>
			<p>
				We regret to inform you that your transaction has been cancelled.
			</p>
			<p>
				Transaction ID: [Transaction ID]
				<br>
				Amount: $[Transaction Amount]
				<br>
				Date: [Transaction Date]
			</p>
			<p>
				If you believe this cancellation is a mistake or need further assistance, please don't hesitate to contact us at:
				<br>
				Email: support@example.com
				<br>
				Phone: +1 (800) 123-4567
			</p>
			<p>
				We apologize for any inconvenience caused.
			</p>
		</div> --}}

		<!-- Additional Information -->
		{{-- <div style="margin-top: 20px;">
			<h3>Additional Information</h3>
			<ul>
				<li>[Additional Info 1]</li>
				<li>[Additional Info 2]</li>
				<!-- Add more points if needed -->
			</ul>
		</div> --}}

		<!-- Footer -->
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
