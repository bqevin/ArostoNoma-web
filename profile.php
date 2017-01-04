<?php
session_start();

require 'core/rb.php';

require_once 'classes/Input.php';
require_once 'classes/Hash.php';
require_once 'classes/Validate.php';

$username = 'kevin.barasa001@gmail.com';

R::setup('mysql:host=localhost; dbname=arosto_noma', 'root', '');


// Get tme Ago


// Get user details
if(isset($username) && !empty($username)){
	$users = R::dispense('users');
	$res = R::getAll('SELECT * FROM users WHERE email = ?', [$username]);

	foreach ($res as $value) {
		$id =  $value['id'];
		$name = $value['name'];
		$email = $value['email'];
		$dob =  $value['dob'];
	}
}

// View another user details from their post
if(Input::exists('get')){
	$user_id = Input::get('user');

	$user = R::dispense('users');
	$res = R::getAll('SELECT * FROM users WHERE id = ?', [$user_id]);

	foreach ($res as $value) {
		$id =  $value['id'];
		$name = $value['name'];
		$email = $value['email'];
		$dob =  $value['dob'];
		$phone = $value['phone'];
		$location = $value['location'];
		$sex = $value['sex'];
	}
	var_dump($id, $name, $email, $dob, $phone, $location, $sex);
}

// Saving a post
if(Input::exists('post')){

	$validate = new Validate();
    if($validate->check($_POST, array('post' => array('required' => true)))){
    	   	
    	$posts = R::dispense('articles');
    	
    	// $posts['post_type'] = Input::get('post_in');
    	// $posts['title'] = Input::get('title');
		$posts['body'] = Input::get('post');
    	// $posts['tag'] = Input::get('tag');
		$posts['author'] = $id;
		$posts['created_at'] = time();

		R::store($posts);
	}
	
	header('location: profile.php');
}


// List all Categories

// List of Segestions


?>
<head>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/semantic.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/semantic.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/custom.css">
<!-- <script src="js/semantic.min.js"></script> -->

</head>
<body>
<!-- Nav bar -->
<div class="ui borderless menu">
	<a href="#" class="item red title">Arosto Noma</a>

<div class="right menu">
	<div class="item ui category search">
	  <div class="ui icon input">
	    <input class="prompt" type="text" placeholder="Search...">
	    <i class="search icon"></i>
	  </div>
	  <div class="results"></div>
	</div>
	<a class="item">Sign Up</a>
	<a class="item" style="margin-right: 30px">Help</a>
</div>
</div>
<!-- End of Nav Bar -->

<!-- Grid Containers  -->
<div class="container" id="example1">

<div class="ui grid">
	<div class="three wide column sticky">
	<!-- Profile Image -->
		<div class="ui card">
		<div class="ui slide masked reveal image">
			<img src="images/avatar.png" class="visible content">
			<img src="images/avatar.png" class="hidden content">
		</div>
		<div class="content">
			<a class="header"><?php echo $name  ?></a>
			<div class="meta">
			  <span class="date">Date of Birth: <?php echo $dob  ?></span>
			</div>
		</div>
		</div>
		<a href="editprofile.php?email="<?php echo $email; ?> >
		<button class="ui basic button">
			  Edit Profile
			  <i class="icon write pull-right"></i>
		</button>
		</a>
	<!-- End of Profile Image -->

	<!-- Tag/category Container -->
		<div class="ui card">
			<div class="content" style="background: #f5f5f5;">
				<div class="header">Categories</div>
			</div>
			<div class="content">
				<div class="ui list">
					<a class="item">#Alcohol</a>
					<a class="item">#Hard Drugs</a>
					<a class="item">#Smoking</a>
					<a class="item">#Arosto Noma</a>
					
				</div>
			</div>
		</div>
	<!-- End of tag/Category container -->
	</div>

	<!-- Text Area -->
	<div class="nine wide column">
		<div class="ui segment">
			<div class="content">
			<div class="ui form">
			<form action="" method="POST">
				<div class="field">
			    <label>Compose Article/Note</label>
			    <textarea rows="2" name="post"></textarea>

				</div>
				
				<button type="submit" name="btn-post" class="ui basic green button">
				<i class="send icon"></i>
				Post</button>
				<select class="ui dropdown post-type pull-right">
				<div class="menu">
					<option value="">Write In</option>
					<option class="item" value="Articles">Articles</option>
					<option class="item" value="Note">Note</option>
				</div>
				</select>
				</form>
			</div>
			</div>
		</div>

		<!-- Feeds -->
		<div class="ui segment">
			<div class="ui feed">

			  <?php
			  	// Get all Posts/Articles details
				$posts = R::dispense('articles');
				$res = R::getAll('SELECT * FROM articles ORDER BY created_at DESC');

				foreach ($res as $value) {
					$user_id = $value['author'];
					$user = R::dispense('users');
					$res = R::getAll('SELECT name FROM users WHERE id = ?', [$user_id]);
					foreach ($res as $result) {
						$name = $result['name'];
					}

					// $title = $value['title'];
					// $tag = $value['tag'];
					$content = $value['body'];
					$postedby = $name;
					$time =  $value['created_at'];
					$likes = $value['likes'];

				    
				    if($value): ?>
				    <div class="event">
					    <div class="label">
			      		<img src="images/profile.png">
				    	</div>
			    	<div class="content">
		      		<div class="summary">
		        		<a href="profile.php?user="<?php echo $user_id; ?> >
		        		<?php echo $name; ?></a> posted on his page
		        		<div class="date pull-right" id="date">
		        		<!-- Get unix epotch to time ago -->
		        		<script type="text/javascript">
			        		var time = <?php echo $time; ?>;
			        		var unix = moment.unix(time).fromNow();
			        		document.write(unix);
						</script>

		        		</div>
		      		</div>
	      			<div class="extra text"><?php echo $content; ?></div>
	      			<div class="meta">
	        			<a class="like">
          				<i class="like icon" id="like" value=""></i><?php echo $likes; ?> Likes
	        			</a>
	      			</div>	
		    		</div>
						</div>
					<?php endif; }?>	
				</div>
			</div>
		</div>

		<div class="four wide column">
			<div class="ui segments">
			<div class="ui segment" style="background: #f5f5f5;">
			    <h3>Suggestions</h3>
			 </div>
			 <div class="segment">
			 <div class="ui middle aligned divided list">
			  <?php
			  	// Get users
				$posts = R::dispense('users');
				$users = R::getAll('SELECT * FROM users WHERE email != ?', [$username]);
				foreach ($users as $value) {
					$id = $value['id'];
					$name = $value['name'];	
				
				if($value): ?>
					<div class="item">
				    <div class="right floated content">
						<div class="ui inverted green button"><i class="user icon"></i>
						<input type="hidden" value=<?php echo $id; ?> >Follow</div>
				    </div>
				    <img class="ui avatar image" src="images/profile.png">
				    <div class="content"> <?php echo $name; ?> </div>
				    </div>
				<?php endif; }?>	
				</div>
			 	
			 </div>
			</div>

			<div class="four wide column">
				<div class="ui segment">
					<h4 style="margin-bottom: 0px;">Links</h4><br/>
					<a class="link" href="">About</a> &nbsp;&nbsp;
					<a class="link" href="">Blog</a> &nbsp;&nbsp;
					<a class="link" href="">Getting Started </a> &nbsp;&nbsp;
					<a class="link" href="">license</a> &nbsp;&nbsp;
					<a class="link" href=""></a>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
