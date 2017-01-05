<?php

require("core/rb.php");

R::setup('mysql:host=localhost; dbname=arosto_noma', 'root', '');
R::setAutoResolve( TRUE );        //Recommended as of version 4.2
	$post = R::dispense( 'articles' );
	$post->body = 'Test Article';
	$id = R::store( $post );          //Create or Update
    echo (R::load( 'articles', $id )); //Retrieve one

?>