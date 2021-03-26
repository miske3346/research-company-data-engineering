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
			<div class="loader-logo"><img src="vendors/images/deskapp-logo.svg" alt=""></div>
			<div class="loader-progress"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
            en cours...
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
