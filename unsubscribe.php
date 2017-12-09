<?php 
require 'database.php';  //connection to database PDO

$step=1;
$subscribe = 1;
$email = $_GET["email"];


if ($step ==1)
{// change to your table name 
$sql = "UPDATE tablename SET subscribe = :subscribe  
            WHERE email = :email";
$stmt = $db->prepare($sql);                                  
   
$stmt->bindParam(':subscribe', $subscribe, PDO::PARAM_INT);    
$stmt->bindParam(':email', $email, PDO::PARAM_STR);

$stmt->execute(); 
echo "You are now unsubscribed";
}
?>