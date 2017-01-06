<?php 

require_once 'core/rb.php';
require_once 'classes/input.php';

if(input::exists()){
	R::setup('mysql:host=localhost; dbname=arosto_noma','root','');
	$user = R::dispense('users');

	$id = "jomwashighadi@gmail.com";
	$name = Input::get('name');
	$emailsettings = Input::get('emailsettings');
	$bio = Input::get('bio');
	$location = Input::get('location');
	$profilepic = Input::get('profilepic');
	$lastupdated = time();

	// Sannitization



	// Move image to designated folder
	$upload_dir = 'images/'; 
	$tmp_name = $_FILES['profilepic']['tmp_name']; 
	$filename = basename($_FILES["profilepic"]["name"]);

	if(!move_uploaded_file($tmp_name, $upload_dir.$name)){
		die("Error: Couldn't Upload Image");
	}
	
	// Update the user details in the DB
	$sql = 'UPDATE users SET name ="'.$name.'",emailsettings ="'.$emailsettings.'",bio ="'.$bio.'",location ="'.$location.'", profilepic ="'.$profilepic.'",lastupdated ='.$lastupdated.' WHERE email ="'.$id.'"';
	
	if(!$id = R::exec($sql)){
		die("Error: Couldn't Updating Profile");	
	}
		

	$res = R::load('users', $id);
	header('Content-type: application/json');

	echo json_encode($res);

}
?>