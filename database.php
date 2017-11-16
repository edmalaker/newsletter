<?php

/*
| $config array is used by $db (below)and is where we put the info to access the database 
| you can get the info  from the site that hosts the database
*/

$config = array( 
 'host' => 'localhost', 
 'username' => 'malaker_ed', 
 'password' => '18eyeballs', 
 'dbname' => 'malaker_newsletter',
   'charset' => 'utf8'
 );


/*
| $db is used by $users (core/init.php) to access the database
*/




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
