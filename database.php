<?php

// $config array is used by $db (below) and is where we put the info to access our database.
// You can get the info from the site that hosts your database (usually in the control panel).
// You need to change all of the 'your_value' to your own values.

$config = array( 
 'host' => 'your_host', //usually localhost
 'username' => 'your_username', 
 'password' => 'your_password', 
 'dbname' => 'your_database_name',
   'charset' => 'utf8'
 );


//connect to database
try{
	$db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';charset=' . $config['charset'], $config['username'], $config['password']);


/*
|setAttribute on $db means that if $db fails to connect to the database it will throw an exception
*/
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}

catch(PDOException $ex) {
    echo "An Error Occurred! Please try again later."; //user friendly message
}
?>
