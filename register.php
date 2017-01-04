<?php 
require 'core/rb.php';
R::setup('mysql:host=localhost; dbname=arosto_noma', 'root', '');

// R::wipe('users');
$user = R::dispense('users');

require_once 'classes/Input.php';
require_once 'classes/Hash.php';
require_once 'classes/Validate.php';

$err = "";

if (Input::exists()) {

    $validate = new Validate();
    if($validate->check($_POST, array('email' => array('unique' => true)))){

    	$validated = $validate->check($_POST, array(
        'name' => array('required' => true),
        'dob' => array('required' => true),
        'sex' => array('required' => true),
        'tel' => array('required' => true),
        'category' => array('required' => true),
        'password' => array('required' => true),
        'location' => array('required' => true) // Use Google MAPS API https://developers.google.com/maps/documentation/javascript/geolocation
    ));

	    if ($validated) {
	    	
	    	$salt = Hash::salt(32);
	    	$password = Hash::make(Input::get('password'), $salt);

	    	$user['name'] = Input::get('name');
	    	$user['dob'] = Input::get('dob');
	    	$user['sex'] = Input::get('sex');
	    	$user['email'] = Input::get('email');
	    	$user['phone'] = Input::get('tel');
	    	$user['category'] = Input::get('category');
	    	$user['password'] = $password;
	    	$user['salt'] = $salt;
	    	$user['location'] = Input::get('location');
	    	
			$id = R::store($user);

			// echo( R::load('users', $id));	
	    }
    }

    $error = $validate->errors();
    foreach ($error as $value) {
    	$err =  "<p class='alert alert-danger'>".$value."</p>";
    }
    
}


?>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Swahili Pot Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    </head>


<?php echo $err; ?>
        <div class="container">
			<div class="panel panel-primary">
				<div class="panel-body">
					<form method="POST" action="" role="form">
						<div class="form-group">
							<h2>Create account</h2>
						</div>
						<div class="form-group">
							<label class="control-label" for="signupName">Your name</label>
							<input id="signupName" name="name" type="text" maxlength="50" class="form-control">
						</div>

						<div class="form-group">
							<label class="control-label" for="signupEmail">Email</label>
							<input id="signupEmail" name="email" type="email" maxlength="50" class="form-control">
						</div>

						<div class="form-group">
							<label class="control-label" for="dateOfBirth">Date Of Birth</label>
							<input id="dateOfBirth" name="dob" type="date" class="form-control">
						</div>

		                <div class="form-group">
		                    <label for="tel" class="control-label">Phone No</label>
	                        <input id="tel" type="tel" name="tel" placeholder="tel" class="form-control">
		                </div>

		                <div class="form-group">
		                    <label for="birthDate" class="control-label">Category</label>
		                    <input id="birthDate" type="text" name="category" placeholder="Category" class="form-control">
		                </div>

		               	<div class="form-group">
		                    <label for="location" class="control-label">Location</label>
	                        <input id="location" type="text" name="location" placeholder="location" class="form-control">
		                </div> 

		                <div class="form-group">
		                    <label class=" control-label">Gender</label>
		                    <div class="">
		                        <div class="row">
		                            <div class="col-md-6">
		                                <label class="radio-inline">
		                                    <input type="radio" name="sex" value="Female">Female
		                                </label>
		                            </div>
		                            <div class="col-md-6">
		                                <label class="radio-inline">
		                                    <input type="radio" name="sex" value="Male">Male
		                                </label>
		                            </div>
		                            
		                        </div>
		                    </div>
		                </div> <!-- /.form-group -->
                

						<div class="form-group">
							<label class="control-label" for="signupPassword">New Password</label>
							<input id="signupPassword" name="password" type="password" maxlength="25" class="form-control" placeholder="at least 6 characters" length="40">
						</div>

						<div class="form-group">
							<label class="control-label" for="signupPasswordagain">Confirm Password</label>
							<input id="signupPasswordagain" name="passwordagain" type="password" maxlength="25" class="form-control" onkeyup="matchPassword();"><span id="status"></span>
						</div>

						<div class="form-group">
							<button id="signupSubmit" name="send" type="submit" class="btn btn-info btn-block">Create your account</button>
						</div>

						<p class="form-group">By creating an account, you agree to our <a href="#">Terms of Use</a> and our <a href="#">Privacy Policy</a>.</p>
						<hr/>
						<p>Already have an account? <a href="#">Sign in</a></p>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function matchPassword(){
			var pass1 = document.getElementById('signupPassword');
			var pass2 = document.getElementById('signupPasswordagain');

			var status = document.getElementById('status');

			if (pass1.value == pass2.value) {
				pass2.style.backgroundColor = '#458B00';
				status.innerHTML = "Passwords Match!"
				// status.className = 'glyphicon glyphicon-ok';
				status.style.color = '#458B00';
			}
			else{
				pass2.style.backgroundColor = '#FF0101';
				status.innerHTML = "Passwords Do Not Match!"
				// status.className = 'glyphicon glyphicon-remove';
				status.style.color = '#FF0101';
			}
		}
	</script>
