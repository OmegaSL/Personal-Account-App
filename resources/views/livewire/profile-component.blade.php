@section('title', 'Profile')

<div>

	<!-- Secondary Menu ============================================= -->
	<div wire:ignore class="bg-primary">
		<div class="container d-flex justify-content-center">
			<ul class="nav secondary-nav">
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
						Account
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('profile-account') ? 'active' : '' }}"
						href="{{ route('profile-account') }}">
						Cards & Bank Accounts
					</a>
				</li>
				{{-- <li class="nav-item">
					<a class="nav-link" href="profile-notifications.html">
						Notifications
					</a>
				</li> --}}
			</ul>
		</div>
	</div>
	<!-- Secondary Menu end -->

	<!-- Content ============================================= -->
	<div id="content" class="py-4">
		<div class="container">
			<div class="row">

				@include('shared.sidebar')

				<!-- Middle Panel
						============================================= -->
				<div class="col-lg-9">

					<!-- Personal Details ============================================= -->
					<div class="bg-light shadow-sm rounded p-4 mb-4">
						<h3 class="text-5 font-weight-400 mb-3">Personal Details
							<a href="#edit-personal-details" data-toggle="modal"
								class="float-right text-1 text-uppercase text-muted btn-link">
								<i class="fas fa-edit mr-1"></i>
								Edit
							</a>
						</h3>
						<div class="row">
							<p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Name</p>
							<p class="col-sm-9">{{ $this->user->full_name }}</p>
						</div>
						<div class="row">
							<p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Date of Birth</p>
							<p class="col-sm-9">{{ date('d-m-Y', strtotime($this->user->birth_date)) }}</p>
						</div>
						<div class="row">
							<p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Address</p>
							<p class="col-sm-9">
								{{ $this->user->address }}
							</p>
						</div>
					</div>
					@include('livewire.modals.profile.edit-personal-details')

					<!-- Email Addresses ============================================= -->
					<div class="bg-light shadow-sm rounded p-4 mb-4">
						<h3 class="text-5 font-weight-400 mb-3">Email Addresses <a href="#edit-email" data-toggle="modal"
								class="float-right text-1 text-uppercase text-muted btn-link"><i class="fas fa-edit mr-1"></i>Edit</a>
						</h3>
						<div class="row">
							<p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Email ID <span
									class="text-muted font-weight-500">(Primary)</span></p>
							<p class="col-sm-9">{{ $this->user->email }}</p>
						</div>
					</div>
					@include('livewire.modals.profile.edit-email-details')

					<!-- Phone ============================================= -->
					<div class="bg-light shadow-sm rounded p-4 mb-4">
						<h3 class="text-5 font-weight-400 mb-3">Phone <a href="#edit-phone" data-toggle="modal"
								class="float-right text-1 text-uppercase text-muted btn-link"><i class="fas fa-edit mr-1"></i>Edit</a>
						</h3>
						<div class="row">
							<p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Mobile <span
									class="text-muted font-weight-500">(Primary)</span></p>
							<p class="col-sm-9">{{ $this->user->phone }}</p>
						</div>
					</div>
					@include('livewire.modals.profile.edit-phone')

					<!-- Security ============================================= -->
					<div class="bg-light shadow-sm rounded p-4">
						<h3 class="text-5 font-weight-400 mb-3">Security <a href="#change-password" data-toggle="modal"
								class="float-right text-1 text-uppercase text-muted btn-link"><i class="fas fa-edit mr-1"></i>Edit</a>
						</h3>
						<div class="row">
							<p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">
								<label class="col-form-label">Password</label>
							</p>
							<p class="col-sm-9">
								<input type="password" disabled class="form-control-plaintext" value="yourPasswordHere" id="password">
							</p>
						</div>
					</div>
					@include('livewire.modals.profile.change-password')

				</div>
				<!-- Middle Panel End -->
			</div>
		</div>
	</div>
	<!-- Content end -->

</div>
