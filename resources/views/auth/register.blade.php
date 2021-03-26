@extends('layouts.app')

@section('content')

<form action="{{ route('register') }}" method="POST">

@csrf

<div class="register-page-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7 px-0">
					<img src="{{ asset('images/blood.png') }}" alt="{{ __('ri7ab.Register') }}">
				</div>
				<div class="col-md-6 col-lg-5 px-0">
					<div class="bg-white box-shadow border-radius-10">
						<div class="wizard-content">
							<div class="tab-wizard2 wizard-circle wizard">

								<h5>{{ __('ri7ab.register_s1') }}</h5>
								<section>
									<div class="form-wrap max-width-600 mx-auto">
									
                                        <div class="select-role">
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                <label class="btn active">
                                                    <input type="radio" value="don" name="role" checked="true" />
                                                    <div class="icon"><img src="{{ asset('app/vendors/images/person.svg') }}" class="svg" alt="{{ __('ri7ab.im_Don' )}}"></div>
                                                    <span>{{ __('ri7ab.iam') }}</span>
                                                    {{ __('ri7ab.im_Don' )}}
                                                </label>
                                                <label class="btn">
                                                    <input type="radio" value="org" name="role" />
                                                    <div class="icon"><img src="{{ asset('app/vendors/images/briefcase.svg') }}" class="svg" alt="{{ __('ri7ab.im_Org' )}}"></div>
                                                    <span>{{ __('ri7ab.iam') }}</span>
                                                    {{ __('ri7ab.im_Org') }}
                                                </label>
                                            </div>
                                        </div>

							            <div id="Don">
                                
                                            <div class="input-group custom">
                                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control form-control-lg @error('first_name') d-none @enderror" placeholder="{{ __('ri7ab.first_name') }}" />
                                                <div class="input-group-append custom">
                                                    <span class="input-group-text"><i class="icon-copy dw dw-user"></i></span>
                                                </div>
                                            </div>
                                            <div class="input-group custom">
                                                <input type="text" name="last_name" class="form-control form-control-lg" placeholder="{{ __('ri7ab.last_name') }}">
                                                <div class="input-group-append custom">
                                                    <span class="input-group-text"><i class="icon-copy dw dw-user"></i></span>
                                                </div>
                                            </div>
                                            <div class="input-group custom">
												<label class="col-sm-4 col-form-label">{{ __('ri7ab.birth_date') }}</label>
                                                <input type="date" name="birth_date" class="form-control form-control-lg" value="1960-11-28" />
                                                <div class="input-group-append custom">
                                                    <span class="input-group-text"><i class="icon-copy dw dw-user"></i></span>
                                                </div>
                                            </div>

                                            <div class="input-group">
												<label class="col-sm-4 col-form-label">{{ __('ri7ab.birth_place') }}</label>
												<div class="col-sm-8">
													<select name="birth_place" class="form-control form-control-lg" title="{{ __('ri7ab.birth_place') }}">
													@include('villes-partial', ['villes'=>$villes, 'r7b'=>''])
													</select>
												</div>
                                            </div>

                                            <div class="input-group">
											<label class="col-sm-4 col-form-label">{{ __('ri7ab.Gender') }}</label>
											<div class="col-sm-8">
												<div class="custom-control custom-radio custom-control-inline pb-0">
													<input type="radio" id="male" name="sex" class="custom-control-input">
													<label class="custom-control-label" for="male">{{ __('ri7ab.Man') }}</label>
												</div>
												<div class="custom-control custom-radio custom-control-inline pb-0">
													<input type="radio" id="female" name="sex" value="Male" class="custom-control-input">
													<label class="custom-control-label" for="female">{{ __('ri7ab.Women') }}</label>
												</div>
											</div>
										</div>

										<div class="input-group">
											<label class="col-sm-4 col-form-label">{{ __('ri7ab.blood_type') }}</label>
											<div class="col-sm-8">
												<select name="blood" class="form-control selectpicker" title="{{ __('ri7ab.blood_type') }}">
												@foreach($groups as $group)
												<option value="{{ $group->id }}">{{ $group->type }}</option>
												@endforeach
												</select>
											</div>
										</div>
                                        
                                        </div>

							            <div id="Org">
                                
                                            <div class="input-group custom">
                                                <input type="text" name="societe_nom" class="form-control form-control-lg" placeholder="{{ __('ri7ab.societe_titre') }}">
                                                <div class="input-group-append custom">
                                                    <span class="input-group-text"><i class="icon-copy dw dw-user"></i></span>
                                                </div>
                                            </div>
											
                                            <div class="input-group custom">
                                                <input type="text" name="nif" class="form-control form-control-lg" placeholder="{{ __('ri7ab.nif') }}">
                                                <div class="input-group-append custom">
                                                    <span class="input-group-text"><i class="icon-copy dw dw-user"></i></span>
                                                </div>
                                            </div>
											
                                            <div class="input-group custom">
                                                <textarea name="about" class="form-control form-control-lg" placeholder="{{ __('ri7ab.about') }}"></textarea>
                                                <div class="input-group-append custom">
                                                    <span class="input-group-text"><i class="icon-copy dw dw-user"></i></span>
                                                </div>
                                            </div>
											
											<div class="input-group">
												<label class="col-sm-4 col-form-label">{{ __('ri7ab.location') }}</label>
												<div class="col-sm-8">
													<select name="location" class="form-control form-control-lg" title="{{ __('ri7ab.location') }}">
													@include('villes-partial', ['villes'=>$villes, 'r7b'=>''])
													</select>
												</div>
                                            </div>

                                            <div class="input-group custom">
                                                <input type="text" name="location" class="form-control form-control-lg" placeholder="{{ __('ri7ab.address') }}">
                                                <div class="input-group-append custom">
                                                    <span class="input-group-text"><i class="icon-copy dw dw-user"></i></span>
                                                </div>
                                            </div>
                                        
                                        </div>
                                        
									</div>
								</section>

								<!-- Step 2 -->
								<h5>{{ __('ri7ab.register_s2') }}</h5>
								<section>
									<div class="form-wrap max-width-600 mx-auto">

										<div class="input-group">
											<input placeholder="{{ __('ri7ab.phone') }}" name="phone" type="number" class="form-control form-control-lg @error('phone') is-invalid @enderror" value="{{ old('phone') }}" autocomplete="phone">
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
											<input placeholder="{{ __('ri7ab.passwd') }}" name="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required autocomplete="new-password"">
											<div class="input-group-append custom @error('password') d-none @enderror">
												<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
											</div>

											@error('password')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
											
										</div>

										
										<div class="input-group">
											<input placeholder="{{ __('ri7ab.confirm_passwd') }}" name="password_confirmation" type="password" class="form-control form-control-lg" required autocomplete="new-password" />
											<div class="input-group-append custom @error('password') d-none @enderror">
												<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
											</div>
											
										</div>

									</div>
								</section>
								<!-- Step 3 -->
								<h5>Contact Methode & Info</h5>
								<section>
									<div class="form-wrap max-width-600 mx-auto">
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Credit Card Type</label>
											<div class="col-sm-8">
												<select class="form-control selectpicker" title="Select Card Type">
													<option value="1">Option 1</option>
													<option value="2">Option 2</option>
													<option value="3">Option 3</option>
												</select>
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label class="col-sm-4 col-form-label">Credit Card Number</label>
											<div class="col-sm-8">
												<input type="text" class="form-control">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">CVC</label>
											<div class="col-sm-3">
												<input type="text" class="form-control">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Expiration Date</label>
											<div class="col-sm-8">
												<div class="row">
													<div class="col-6">
														<select class="form-control selectpicker" title="Month" data-size="5">
															<option value='01'>January</option>
															<option value='02'>February</option>
															<option value='03'>March</option>
															<option value='04'>April</option>
															<option value='05'>May</option>
															<option value='06'>June</option>
															<option value='07'>July</option>
															<option value='08'>August</option>
															<option value='09'>September</option>
															<option value='10'>October</option>
															<option value='11'>November</option>
															<option value='12'>December</option>
														</select>
													</div>
													<div class="col-6">
														<select class="form-control selectpicker" title="Year" data-size="5">
															<option>2020</option>
															<option>2019</option>
															<option>2018</option>
															<option>2017</option>
															<option>2016</option>
															<option>2015</option>
															<option>2014</option>
															<option>2013</option>
															<option>2012</option>
															<option>2011</option>
															<option>2010</option>
															<option>2009</option>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
								</section>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- success Popup html Start -->
<button type="button" id="success-modal-btn" hidden data-toggle="modal" data-target="#success-modal" data-backdrop="static">Launch modal</button>
	<div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered max-width-400" role="document">
			<div class="modal-content">
				<div class="modal-body text-center font-18">
					<div class="mb-30 text-center"><img src="{{ asset('images/blood.gif') }}"></div>
					Nous avons bien reçu votre inscription et vous en remercions !
				</div>
				<div class="modal-footer justify-content-center">
					<input type="submit" class="btn btn-primary" value="{{ __('ri7ab.Register') }}" />
				</div>
			</div>
		</div>
	</div>

</form>

@endsection


@section('my_r7b')
<script>

/*  -- To-Do in future , now Jquery+If work it :p

	const ri7ab = document.querySelector('input[type=radio][name=role]');
	
	ri7ab.addEventListener("change", function(event) { 
		-> trigger API Organisation Callback
	});
*/

$(document).ready(function () {

	document.querySelector('#Org').style.display = "none";

    $('input[type=radio][name=role]').change(function() {

        if (this.value == 'don') {

			document.querySelector('#Don').style.display = "block";
			document.querySelector('#Org').style.display = "none";

			$('#Org').find('input, textarea, button, select').prop('disabled', false);

        }else if (this.value == 'org') {

			document.querySelector('#Org').style.display = "block";
			document.querySelector('#Don').style.display = "none";

            $('#Don').find('input, textarea, button, select').prop('disabled', false);
        }

    });
});

</script>
@endsection