@extends('layouts.app')

@section('content')
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
					<img src="{{ asset('images/hero.png') }}" />
				</div>
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-danger">{{ __('ri7ab.SignIn') }}</h2>
						</div>
						<form action="{{ route('login') }}" method="POST">

                        @csrf
							
							<div class="input-group">
								<input placeholder="{{ __('ri7ab.phone') }}" name="phone" type="number" class="form-control form-control-lg @error('phone') is-invalid @enderror" value="{{ old('phone') }}" autocomplete="phone" autofocus>
								<div class="input-group-append custom @error('phone') d-none @enderror">
									<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							<div class="input-group">
								<input placeholder="{{ __('ri7ab.passwd') }}" name="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required autocomplete="current-password">
								<div class="input-group-append custom @error('password') d-none @enderror">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							<div class="row pb-30">

								<div class="col-6">
									<div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="remember" id="customCheck1" {{ old('remember') ? 'checked' : '' }}>
										<label class="custom-control-label" for="customCheck1">{{ __('ri7ab.remember_me') }}</label>
									</div>
                                </div>

                                @if (Route::has('password.request'))
								<div class="col-6">
									<div class="forgot-password"><a href="{{ route('password.request') }}">{{ __('ri7ab.forgot_passwd') }}</a></div>
                                </div>
                                @endif

							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
											<input class="btn btn-danger btn-lg btn-block" type="submit" value="{{ __('ri7ab.Login') }}">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
    </div>

@endsection
