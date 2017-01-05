<?php

session_start();
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
                $password = md5($password);
                if($password == $pass){
                    $_SESSION['username'] = $username;

                    //If user has Checked remember this code is executed

                    // if ($remember) {
     //                    $hash = Hash::unique();
     //                    $hashCheck = R::count('users_session', 'id = ?', $res['id']); 
                        
     //                    if (!$hashCheck) {

     //                     $usersessions = R::dispense('users_session');

     //                     $usersessions['user_id'] = $res['id'];
     //                     $usersessions['hash'] = $hash;

     //                     R::store($usersessions);

     //                    } 
     //                    else {
     //                        // $hash = $hashCheck->first()->hash;
     //                    }
                        //set Cookie to store $remember time()+$expiry,
                        
                    //}
                  header('location: articles/index.php');
                }
                else{
                    $error = '<div class="ui red label" style="margin:10px;">ERROR: Wrong Password!</div>';
                }
            }
            else{
                $error = '<div class="ui red label" style="margin:10px;">Email you entered is not registered to any account yet! </br>You can sign up below.</div>';
            }

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
      max-width: 450px;
    }
  </style>
</head>
<body>
<!--Login form-->
<div class="ui middle aligned center aligned grid" >
  <div class="column">
    <h2 class="ui image header">
    <img class="ui centered image"  src="images/menu-logo.png">
      <div class="content" style="color:#fff;">
        Log-in to your account
      </div>
    </h2>
    <br>
      <?php echo $error; ?>
    <form role="form"  action="" method="POST" class="ui large form">
      <div class="ui stacked secondary  segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="username" placeholder="E-mail address" autofocus required>
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Password" value="" required>
          </div>
        </div>
        <div class="field">
          <input type="hidden" name="token" value=""> 
          <input type="submit" name="Signin" value="sign in" class="ui fluid large red submit button">
        </div>
      </div>
      <div class="ui error message"></div>

    </form>

    <div class="ui message">
      New to Arosto Noma? <a href="register.php">Register</a>
    </div>
  </div>
</div>

<!--Load the scripts-->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
<script src="semantic-ui/semantic.js"></script>

<script src="homepage.js"></script>
<script>
  $(document)
    .ready(function() {
      $('.ui.form')
        .form({
          fields: {
            username: {
              identifier  : 'username',
              rules: [
                {
                  type   : 'email',
                  prompt : 'Please enter your e-mail'
                },
                {
                  type   : 'email',
                  prompt : 'Please enter a valid e-mail'
                }
              ]
            },
            password: {
              identifier  : 'password',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please enter your password'
                },
                {
                  type   : 'length[6]',
                  prompt : 'Your password must be at least 6 characters'
                }
              ]
            }
          }
        })
      ;
    })
  ;
</script>
</body>
</html>