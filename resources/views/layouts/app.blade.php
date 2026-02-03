<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('landing/assets/img/logo.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Banque de Sang') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('app/vendors/styles/core.css') }}" rel="stylesheet" />
    <link href="{{ asset('app/vendors/styles/icon-font.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('app/src/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('app/vendors/styles/style.css') }}" rel="stylesheet">

</head>
<body>

@guest
    <div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
                <a href="{{ url('/') }}" class="mx-2">
                    <img src="http://localhost:8000/landing/assets/img/logo.png" alt="{{ config('app.name', 'Banque de Sang') }}" />
                    <span class="text-body px-1">Banque de</span>
                    <span class="font-weight-bold text-danger">Sang</span>
                </a>
			</div>
			<div class="login-menu">
				<ul>
                    @if(Route::current()->getName() == 'register')
                        <li><a href="{{ route('login') }}">{{ __('ri7ab.Login') }}</a></li>
                    @elseif(Route::current()->getName() == 'login')
                        <li><a href="{{ route('register') }}">{{ __('ri7ab.Register') }}</a></li>
                    @endif
				</ul>
			</div>
		</div>
	</div>
@else
<div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo">
            <img src="http://localhost:8000/landing/assets/img/logo.png" alt="{{ config('app.name', 'Banque de Sang') }}" />
                    <span class="text-body px-1">Banque de</span>
                    <span class="font-weight-bold text-danger">Sang</span>
            </div>
			<div class="loader-progress"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
            en cours...
			</div>
		</div>
	</div>

    <div class="header">
		<div class="header-left">
			<div class="menu-icon dw dw-menu"></div>
			<div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
			<div class="header-search">
				<form>
					<div class="form-group mb-0">
						<i class="dw dw-search2 search-icon"></i>
						<input type="text" class="form-control search-input" placeholder="Search Here">
						<div class="dropdown">
							<a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
								<i class="ion-arrow-down-c"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="form-group row">
									<label class="col-sm-12 col-md-2 col-form-label">From</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-12 col-md-2 col-form-label">To</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-12 col-md-2 col-form-label">Subject</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text">
									</div>
								</div>
								<div class="text-right">
									<button class="btn btn-primary">Search</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="header-right">
			<div class="dashboard-setting user-notification">
				<div class="dropdown">
					<a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
						<i class="dw dw-settings2"></i>
					</a>
				</div>
			</div>
			<div class="user-notification">
				<div class="dropdown">
					<a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
						<i class="icon-copy dw dw-notification"></i>
						<span class="badge notification-active"></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<div class="notification-list mx-h-350 customscroll">
							<ul>
                            @foreach($notifications as $notify)
								<li>
									<a href="#">
										<img src="{{ asset('landing/assets/img/logo.png') }}" alt="{{ $notify->ville->nom }}" />
										<h3>{{ $notify->demander}} | {{ $notify->priority }}</h3>
										<p>{{ $notify->description}}</p>
									</a>
								</li>
                            @endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
						<span class="user-icon">
							<img src="https://cdn.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png" alt="">
						</span>
						<span class="user-name">{{ Auth::user()->name }}</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
						<a class="dropdown-item" href="{{ route('profile') }}"><i class="dw dw-user1"></i> Profile</a>
						<a class="dropdown-item" href="{{ route('setting') }}"><i class="dw dw-settings2"></i> Setting</a>
						<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="dw dw-logout"></i> {{ __('Logout') }}</a>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                        </form>

                    </div>
				</div>
			</div>
		</div>
	</div>

@endguest
            
    @yield('content')

    <script src="{{ asset('app/vendors/scripts/core.js') }}"></script>
	<script src="{{ asset('app/vendors/scripts/script.min.js') }}"></script>
	<script src="{{ asset('app/vendors/scripts/process.js') }}"></script>
	<script src="{{ asset('app/vendors/scripts/layout-settings.js') }}"></script>
	<script src="{{ asset('app/src/plugins/jquery-steps/jquery.steps.js') }}"></script>
	<script src="{{ asset('app/vendors/scripts/steps-setting.js') }}"></script>
    @yield('my_r7b')

</body>
</html>
