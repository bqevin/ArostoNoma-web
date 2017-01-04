<head>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/semantic.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/semantic.min.js"></script>

<!-- <link rel="stylesheet" type="text/css" href="css/semantic.min.css">
<script src="js/semantic.min.js"></script> -->

<link rel="stylesheet" type="text/css" href="css/custom.css">
<style type="text/css">
.uploadbnt{
	width: 290px !important;
	margin-top: .875em !important;
}
label{
	margin-bottom: 6px !important;
	font-weight: 600 !important;
    font-size: 14px !important;
}
.settings .segment{
	padding: 0px;
}
.settings .segment a{
	padding: 1em !important;
	display: block;
}
.active{
	border-left: solid 3px #000;
	background: #f2f2f2;
}
.eight{
    margin-right: 6.25%;
}
</style>
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
<div class="three wide column">
<div class="ui segments settings">
	<div class="ui segment" style="background: #f5f5f5; padding: 1em;">
		<h3>Personal Settings</h3>
	</div>
	<div class="ui segment">
	<p><a class="stn-item active" href="#">Profile</a></p>
	</div>
	<div class="ui segment">
	<p><a class="stn-item" href="#">Account</a></p>
	</div>
	<div class="ui segment">
	<p><a class="stn-item" href="#">Contacts/Emails</a></p>
	</div>
	<div class="ui segment">
	<p><a class="stn-item" href="#">Notes & Articles</a></p>
	</div>
</div>
</div>

<div class="eight wide column">
<h2>Personal Profile</h2>
<div class="ui equal width form">
    <div class="field">
      <label>Full Name</label>
      <input type="text" placeholder="Full Name" name="name">
    </div>

    <div class="field">
    <label>Public Email</label>
    <select class="ui dropdown" name="email-settings" style="width: 50%;">
		<div class="menu">
		<option class="item" value="don't-show">Don't Show my Email</option>
		<option class="item" value=""><?php //echo $email; ?></option>
		</div>
	</select>
	<i>You can manage verified email addresses in your email settings.</i>
    </div>
    
    <div class="field">
      <label>Bio</label>
      <textarea rows="2" name="bio" placeholder="Tell a little about yourself"></textarea>
    </div>
    <div class="field">
      <label>Location</label>
      <input name="location" placeholder="Location">
    </div>
    <button class="ui submit button" type="submit">
		Update Profile
	</button>
  </div>
</div>

<div class="four wide column">

<div class="ui special cards">
<h3>Profile Picture</h3>
  <div class="card">
    <div class="blurring dimmable image">
      <div class="ui dimmer">
        <div class="content">
          <div class="center">
            <div class="ui inverted button">Upload New Image</div>
          </div>
        </div>
      </div>
      <img src="images/avatar.png">
    </div>
  </div>
</div>
<div class="item">
<button class="ui submit button uploadbnt" type="submit" >
	<i class="icon upload"></i>
	Upload New Image
</button>
</div>
</div>

</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$(".stn-item").on('click',function(){
			$(".stn-item").removeClass('active');
			$(this).addClass('active');
		});
	});
</script>
</body>