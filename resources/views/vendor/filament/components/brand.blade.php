@if ($setting)
	<img src="{{ $setting->site_logo == null ? asset('assets/images/logo.png') : asset("storage/$setting->site_logo") }}"
		alt="Logo" class="h-10" />
@else
	<img src="{{ asset('assets/images/logo.png') }}" alt="Icon" class="h-full w-full object-contain" />
@endif
{{-- <img src="{{ asset('favicon.ico') }}" alt="Icon" class="h-full w-full object-contain" /> --}}
