<?php
require 'core/rb.php';

require_once 'classes/Input.php';
require_once 'classes/Hash.php';
require_once 'classes/Validate.php';

$error = "";
R::setup('mysql:host=localhost; dbname=arosto_noma', 'root', '');

$user = R::dispense('users');

if (Input::exists()) {
    $validate = new Validate();
  
	if($validated = $validate->check($_POST, array(
	    'username' => array('required' => true),
	    'password' => array('required' => true)
	    ))){

			$username = Input::get('username');
			$password = Input::get('password');
			$remember = (Input::get('remember') === 'on') ? true : false;

			if (R::count('users', 'email=?', [$username]) != 0) {
				$res = R::getAll('SELECT * FROM users WHERE email = ?', [$username]);

				foreach ($res as $value) {
					$pass = $value['password'];
					$salt = $value['salt'];
				}
				
				$password = Hash::make($password, $salt);
				var_dump($password);
				if($password == $pass){
					$_SESSION['username'] = $username;

					//If user has Checked remember this code is executed
					if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = R::count('users_session', 'id = ?', $res['id']); 
                      	
                        if (!$hashCheck) {

                        	$usersessions = R::dispense('users_session');

                        	$usersessions['user_id'] = $res['id'];
                        	$usersessions['hash'] = $hash;

                        	R::store($usersessions);

                        } 
                        else {
                            // $hash = $hashCheck->first()->hash;
                        }
                        //set Cookie to store $remember time()+$expiry,
                        
                    }
                  header('location: profile.php?id='.$username.'');
				}
				else{
					$error = '<p class="alert alert-danger">ERROR: Wrong Password!</p>';
				}
			}
			else{
				$error = '<p class="alert alert-danger">ERROR: Username Doesn"t Exist!</p>';
			}

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
    <!-- <link rel="stylesheet" type="text/css" href="css/custom.css"> -->
</head>
<body>
<div class="container" style="margin-top:40px">
<div class="row">
    <div class="col-sm-6 col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong> Sign in to continue</strong>
            </div>
            <div class="panel-body">
                <form role="form" action="" method="POST">
                    <fieldset>
                    <?php echo $error; ?>
                        <div class="row">
                            <div style="text-align: center; margin-bottom: 30px;"  class="center-block">
                                <img class="profile-img img-circle"
                                    src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120" alt="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="login glyphicon glyphicon-user"></i>
                                        </span> 
                                        <input class="form-control" placeholder="Email" name="username" type="text" autofocus required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-lock"></i>
                                        </span>
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                <div class="check">
                                    <label class="checkbox">
                                      <input type="checkbox" name="remember" checked=""><i></i>Remember my Password</label>
                                </div>
                                </div>
                                <div class="form-group">
                                <input type="hidden" name="token" value="">
                                    <input type="submit" class="btn btn-lg btn-primary btn-block" name="Signin" value="Signin">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>