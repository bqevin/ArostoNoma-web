<?php 
require_once 'core/rb.php';
require_once 'classes/input.php';

if(input::exists()){
	R::setup('mysql:host=localhost; dbname=arosto_noma','root','');
	$user = R::dispense('users');

	$id = "kevin.barasa001@gmail.com";
	$name = Input::get('name');
	$emailsettings = Input::get('emailsettings');
	$bio = Input::get('bio');
	$location = Input::get('location');
	$profilepic = Input::get('profilepic');
	$lastupdated = time();
	
	$sql = 'UPDATE users SET name ="'.$name.'",emailsettings ="'.$emailsettings.'",bio ="'.$bio.'",location ="'.$location.'", profilepic ="'.$profilepic.'",lastupdated ='.$lastupdated.' WHERE email ="'.$id.'"';
	
	$id = R::exec($sql);

	// $res = R::load('users', $id);
	// json_encode($res);
	// header('Content-type/json');

}
?>