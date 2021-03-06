<?php 
require 'database.php'; //connection to database

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
//This needs to be changed to your specific host
require '../../vendor/autoload.php';


$messagessent = 0; //variable to track how many messages are sent each cron job

//use arrays to store all of the subjects and body messages
$messagesubject = array();
$messagebody = array();
$messagealtbody = array();



//get messages from database
$sql= "SELECT id, subject, body, altbody FROM messagesTablename";
$stmt = $db->prepare($sql);
$stmt->execute();



//add each message to the array 
while ($row = $stmt->fetchObject()) {

	$id = $row->id;
	$messagesubject[$id] = $row->subject;
	$messagebody[$id] = $row->body;
	$messagealtbody[$id] = $row->altbody;
}






//select subscribed users
$sql2= "SELECT name, email, followup FROM subscribersTablename WHERE subscribe = 0";
$stmt2 = $db->prepare($sql2);
$stmt2->execute();

//count number of users
$total = $stmt2->rowCount();  //total number of subscribers
echo '<p>Number of subscribers:'.$total.'</p>';


//count number of messages
$messagenumber = sizeof($messagesubject); //this is the total number of messages in database
echo 'Total number of messages in database '.$messagenumber.'<br /><hr />';


//for each subscriber echo their name and email
while ($row = $stmt2->fetchObject()) {

	$toname = $row->name;
	$toemail = $row->email;
	$followup = $row->followup;
	
	echo '<p>Mailing to '.$toname.'  - '.$toemail.'<br />';
	echo 'Message Number: '.$followup.'<br></p>';
	
	
	// check to see if this user already received the last message 
	if ($followup < $messagenumber){
	
	// send the email
	try {
		
	$mail = new \PHPMailer;
		
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output - 0 for no output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp1.example.com';  // Specify main and backup SMTP servers - get this information from your host
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'user@example.com';                 // SMTP username for the email that you are sending from
    $mail->Password = 'secret';                           // SMTP password for the email that you are sending from
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted - mine uses ssl
    $mail->Port = 587;                                    // TCP port to connect to - get this information from your host
	
	$fromemail = '';
	$fromname = '';
	
	
	
	$subject = $messagesubject[$followup];
	$body = $messagebody[$followup];
	$altbody = $messagealtbody[$followup];

    
	//Recipients
   	$mail->setFrom($fromemail, $fromname);   //from email and who is sending
	
	$mail->addAddress($toemail, $toname);     // Add a recipient
	

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = $altbody;

    $mail->send();
    echo '<strong>Message Sent</strong><br /><hr />';
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;

}


//update the database followup number
$followup++;

$sql3 = "UPDATE subscribersTablename SET followup = :followup  
            WHERE email = :email";
$stmt3 = $db->prepare($sql3);                                  
   
$stmt3->bindParam(':followup', $followup, PDO::PARAM_INT);    
$stmt3->bindParam(':email', $toemail, PDO::PARAM_STR);

$stmt3->execute(); 



	}
	
}

echo 'Total Number of Messages Sent = '.$messagessent;

?>
