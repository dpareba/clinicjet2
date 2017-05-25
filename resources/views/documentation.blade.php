{{-- 
	
	^ Create Database for the project

	^ Add Authentication Scaffolding to project using php artisan make:auth

	^ In config/app.php, change value of 'name' => env('APP_NAME', 'ClinicJet'),

	^ .env file, update APP_NAME=ClinicJet

	^ Update the design of welcome.blade.php

	^ update route of Home to @@<a class="link-doc" href="{{ url('check') }}">Home</a>@@ in welcome.blade.php

	^ Edit Design of register.blade.php and layouts/app.blade.php

	^ Edit Design of login.blade.php

	^ For email verification post user registration
		# Add 2 fields to users table migration
		$table->boolean('verified')->default(false);
        $table->string('token')->nullable();

        # Redirect the user to login page post registration,
        	protected $redirectTo = '/login';

        # Edit RegisterController.php
        	In create function of RegisterController, edit the following
        	'name' => Str::upper($data['name']),

        	From RegistersUsers traits of RegisterController, copy and edit the register function
        	 public function register(Request $request)
		    {
		        $this->validator($request->all())->validate();

		        event(new Registered($user = $this->create($request->all())));

		        Mail::to($user->email)->send(new ConfirmationEmail($user));

		        return redirect()->route('login')->withStatus('Please click on the activatation link we have sent to your e-mail id inorder to activate your account.');
		    }

	    # Create mail using php artisan make:mail ConfirmationEmail

	    # Edit ConfirmationEmail.php
				public function build()
			    {
			        return $this->view('emails.confirmation');
			    }

	    # Create view emails.confirmation.blade.php

	    # Redirect users to the check route after login in LoginController.php
	    		protected $redirectTo = '/check';

		# In AuthenticatesUsers trait, update the credentials function
			protected function credentials(Request $request)
		    {
		        return $request->only($this->username(), 'password') + ['verified'=>true];
		    }

	    # Inorder to generate token for user, boot the User model
	    	public static function boot(){
		        parent::boot();

		        static::creating(function ($user){
		            $user->token = str_random(40);
		        });
		    }

	    # Add the following route in web.php inorder to confirm the token sent on email
	    	Route::get('register/confirm/{token}','Auth\RegisterController@confirmEmail');

		# In ResetPasswordController.php, redirect to login after resetting password
				protected $redirectTo = '/login';

		# In ResetsPasswords.php, remove the following in resetPassword function inorder to prevent users from logging in directly after a password reset
				//$this->guard()->login($user);		

	^ Update the design of reset password views, namely auth/passwords/email.blade.php and auth/passwords/reset.blade.php
	
	^ Set format of welcome and password reset mails
		# edit config/mail.php: 'from' => [
	        'address' => env('MAIL_FROM_ADDRESS', 'support@clinicjet.com'),
	        'name' => env('MAIL_FROM_NAME', 'ClinicJet Support'),
	    	]

    	# run php artisan vendor:publish to publish views for email

    	# in resources/views/vendor/notifications.email.blade.php, add 
    			@if (! empty($salutation))
				{{ $salutation }}
				@else
				Regards,<br>The {{ config('app.name') }} Team
				@endif

    ^ Add field for user avatar to User migration
    	#  $table->string('avatar')->default('default.jpg');			

--}}