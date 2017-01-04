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
	    	

	    	//$salt = Hash::salt(32);
	    	$password = md5(Input::get('password'));

	    	$user['name'] = Input::get('name');
	    	$user['dob'] = Input::get('dob');
	    	$user['sex'] = Input::get('sex');
	    	$user['email'] = Input::get('email');
	    	$user['phone'] = Input::get('tel');
	    	$user['category'] = Input::get('category');
	    	$user['password'] = $password;
	    	//$user['salt'] = $salt;
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


<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properities -->
  <title>Arosto Noma | Portable Rehab for drug awareness and counselling</title>

  <link rel="stylesheet" type="text/css" href="semantic-ui/semantic.css">
  <link rel="stylesheet" type="text/css" href="homepage.css">
  <link rel="stylesheet" type="text/css" href="iconfonts/flaticon.css">
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/components/icon.min.css'>
  <style type="text/css">
      body {
        background: url('images/bg.jpg') fixed;
        background-size: cover;
        padding: 0;
        margin: 0;
        overflow:hidden;
      }


    body > .grid {
      height: 100%;
    }
    .image {
      margin-top: 150px;
    }
    .column {
      max-width: 800px;
    }
  </style>
</head>

<body>
<!--Register form-->
<div class="ui middle aligned center aligned grid" >
<div class="column">
    <h2 class="ui image header">
    <img class="ui centered image"  src="images/menu-logo.png">
      <div class="content" style="color:#fff;">
        Create your Arosto Noma account
      </div>
    </h2> <br>
    <?php echo $err; ?>
    <!--Body content start here-->
    <div class="ui ordered steps" style="width: 100% !important;">
	  <div class="active step">
	    <div class="content">
	      <div class="title">Basic information</div>
	      <div class="description">Create your login credentials</div>
	    </div>
	  </div>
	  <div class="disabled step">
	    <div class="content">
	      <div class="title">Personal infomation</div>
	      <div class="description">Users privacy our priority</div>
	    </div>
	  </div>
	  <div class="disabled step">
	    <div class="content">
	      <div class="title">Customization info</div>
	      <div class="description">Get matched with suitable help</div>
	    </div>
	  </div>
	</div>
	<div class="ui attached segment">
	<form role="form"  action="" method="POST" class="ui large form">
	  <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input placeholder="You name" id="signupName" name="name" type="text" maxlength="50" autofocus required>
          </div>
       </div>
       <div class="field">
          <div class="ui left icon input">
            <i class="mail icon"></i>
            <input placeholder="Email address" id="signupEmail" name="email" type="email" maxlength="50" required>
          </div>
       </div>
       <div class="field">
          <div class="ui left icon input">
            <i class="privacy icon"></i>
            <input placeholder="Set password" id="signupPassword" name="password" type="password" maxlength="25" length="40" required>
          </div>
       </div>
       <div class="field">
          <div class="ui left icon input">
            <i class="privacy icon"></i>
            <input  placeholder="Repeat password" id="signupPasswordagain" name="passwordagain" type="password" maxlength="25" class="form-control" onkeyup="matchPassword();" required><span id="status"></span>
          </div>
       </div>  
	</form>
	</div>
</div>
</div>
        <div class="container">
			<div class="panel panel-primary">
				<div class="panel-body">
					<form method="POST" action="" role="form">
						<div class="form-group">
							<h2>Create account</h2>
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

<!--Load the scripts-->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
<script src="semantic-ui/semantic.js"></script>
<script src="homepage.js"></script>
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
</body>
</html>

