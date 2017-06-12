<head>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/semantic.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/semantic.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/sweetalert.css">

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
.upload-img{
    width: 100%;
    margin-top: .875em !important;
}
.inputfile {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
}
.pic-card{
	width: initial !important;
}
.input-focused{
	background: #f3f3f3 !important;
}
.input-focused:focus{
	background: #fff !important;
}

</style>
<script type="text/javascript">
	
$(document).ready( function() {
	
});

</script>
</head>
<body>

<!-- Nav bar -->
<div class="ui borderless menu">
<a href="#" class="item red title">Arosto Noma</a>

<div class="right menu">
<div class="item ui category search">
  <div class="ui icon input">
    <input class="prompt input-focused" type="text" placeholder="Search...">
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
<form action="/" id="updateprofile">
<div class="ui equal width form">
    <div class="field">
      <label>Full Name</label>
      <input class="input-focused" type="text" placeholder="Full Name" name="name">
    </div>

    <div class="field">
    <label>Public Email</label>
    <select class="ui dropdown input-focused" name="emailsettings" style="width: 50%;">
		<div class="menu">
		<option class="item" value="don't-show">Don't Show my Email</option>
		<option class="item" value=""><?php //echo $email; ?></option>
		</div>
	</select>
	<i>You can manage verified email addresses in your email settings.</i>
    </div>
    
    <div class="field">
      <label>Bio</label>
      <textarea class="input-focused" rows="2" name="bio" placeholder="Tell a little about yourself"></textarea>
    </div>
    <div class="field">
      <label>Location</label>
      <input class="input-focused" name="location" placeholder="Location">
    </div>
    <button class=" positive ui submit button" type="submit">
		Update Profile
	</button>
	<button class="negative ui button" type="reset">
	  Discard
	</button>
  </div>
  </form>
</div>


<div class="four wide column">

<div class="ui special cards">
<h3>Profile Picture</h3>
  <div class="card pic-card">
    <div class="blurring dimmable image">
      <img id="profilepic" src="images/avatar.png">
    </div>
  </div>
</div>
<div class="item">

	<input name="profilepic" type="file" form="updateprofile" id="file" class="inputfile inputfile-1"/>
	<label for="file" class="ui button upload-img"><i class="icon upload"></i><span>Upload New Image &hellip;</span></label>
</div>
</div>

</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		// Changing the left border of the menu on click
		$(".stn-item").on('click',function(){
			$(".stn-item").removeClass('active');
			$(this).addClass('active');
		});

		// Get the selected image profile and Cha button text ux
		var inputs = document.querySelectorAll( '.inputfile' ); 
		Array.prototype.forEach.call( inputs, function( input ){
		var label	 = input.nextElementSibling, 
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function(e){
			var	fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
			});
		});

		// Posting/Updating the Form Data #
		$('#updateprofile').submit(function(){
			event.preventDefault();
			// URL sending our data to
			var url = 'editprofile.inc.php',
				formData = new FormData(this);

			$.ajax({
	            type:'POST',
	            url: url,
	            data:formData,
	            cache:false,
	            contentType: false,
	            processData: false,
	            success:function(data){
	                swal("Successful!", "You Updated Your Profile!", "success");
	                console.log(data);
	            },
	            error: function(data){
	                swal("Error!", "Error Updated Your Profile!", "error");
	                console.log(data);
	            }
	        });

		});

		// Generate image preview before upload
		function readURL(input) {
	        if (input.files && input.files[0]) {
	            var reader = new FileReader();

	            reader.onload = function (e) {
	                $('#profilepic').attr('src', e.target.result);
	            }
	            reader.readAsDataURL(input.files[0]);
	        }
	    }

	    $("#file").change(function () {
	        readURL(this);
	    });
			
	});

</script>
</body>