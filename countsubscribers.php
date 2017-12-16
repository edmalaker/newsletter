<?php 
require 'database.php'; //connection to database

//select subscribed users
$sql= "SELECT name, email FROM yourTable WHERE subscribe = 0";
$stmt = $db->prepare($sql);
$stmt->execute();

//count number of users
$total = $stmt->rowCount();  //total number of subscribers
echo '<p>Number of subscribers:'.$total.'</p>';


//for each subscriber echo their name and email
while ($row = $stmt->fetchObject()) {

	$thisname = $row->name;
	$thisemail = $row->email;

	echo $thisname.'  - ';
	echo $thisemail.'<br>';
}


?>