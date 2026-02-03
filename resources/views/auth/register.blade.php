@extends('layouts.app')

@section('content')

<form action="{{ route('register') }}" enctype="multipart/form-data" method="POST">

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
													<input type="radio" id="{{ __('ri7ab.Man') }}" name="sex" class="custom-control-input">
													<label class="custom-control-label" for="{{ __('ri7ab.Man') }}">{{ __('ri7ab.Man') }}</label>
												</div>
												<div class="custom-control custom-radio custom-control-inline pb-0">
													<input type="radio" id="{{ __('ri7ab.Women') }}" name="sex" value="Male" class="custom-control-input">
													<label class="custom-control-label" for="{{ __('ri7ab.Women') }}">{{ __('ri7ab.Women') }}</label>
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
                                                <input type="text" name="address" class="form-control form-control-lg" placeholder="{{ __('ri7ab.address') }}">
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


									<div class="input-group custom">
									
									<div id="cover_preveiw" class="img-thumbnail"></div>

									<input type="file" name="ri7ab" id="img" class="custom-file-input preview-item" data-preview-place="#cover_preveiw" accept="image/*">
									<label class="custom-file-label" for="img">{{ __('ri7ab.profile_picture') }}</label>
                                    
									</div>
									

									<div class="input-group">
											<label class="col-sm-4 col-form-label">{{ __('ri7ab.contact_method') }}</label>
											<div class="col-sm-8">
												<select name="contact_method" class="form-control selectpicker" title="{{ __('ri7ab.contact_method')}}">
													<option value="WhatsApp">Whatsapp</option>
													<option value="SMS">SMS</option>
													<option value="Touts">Touts</option>
												</select>
											</div>
									</div>
										<div class="input-group">
											<label class="col-sm-4 col-form-label">{{ __('ri7ab.contact_time') }}</label>
											<div class="col-sm-8">
														<select name="contact_time" class="form-control selectpicker" title="{{ __('ri7ab.contact_time') }}">
															<option value='24h'>24h/24h</option>
															<option value='8h-15h'>De 8h à 15h</option>
															<option value='15h-23h'>De 15h à 23h</option>
														</select>
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

	var imgPreview = function (input, reader_place) {

	var reader = new FileReader();
	reader.onload = function (e) {
		$(reader_place).html($($.parseHTML('<img>')).addClass('img-editing img-thumbnail').attr('src', e.target.result));
	};
	reader.readAsDataURL(input.files[0]);
	};

	$('.preview-item').on('change', function () {
	imgPreview(this, $(this).attr('data-preview-place'));
	});

});

</script>
@endsection