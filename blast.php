<?php 
require 'database.php'; //connection to database

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
//This needs to be changed to your specific host
require '../../vendor/autoload.php';

//This needed to be changed on mine to what I have here
$mail = new \PHPMailer;

//select subscribed users
$sql= "SELECT name, email FROM yourTable WHERE subscribe = 0";
$stmt = $db->prepare($sql);
$stmt->execute();

//count number of users
$total = $stmt->rowCount();  //total number of subscribers
echo '<p>Number of subscribers:'.$total.'</p>';


//for each subscriber echo their name and email
while ($row = $stmt->fetchObject()) {

	$toname = $row->name;
	$toemail = $row->email;
	
	echo $toname.'  - ';
	echo $toemail.'<br>';

	try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output - 0 for no output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp1.example.com';  // Specify main and backup SMTP servers - get this information from your host
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'user@example.com';                 // SMTP username for the email that you are sending from
    $mail->Password = 'secret';                           // SMTP password for the email that you are sending from
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted - mine uses ssl
    $mail->Port = 587;                                    // TCP port to connect to - get this information from your host
    
	//Recipients
    $mail->setFrom('from@example.com', 'Mailer');   //from email and who is sending
	
	
    
	$mail->addAddress($toemail, $toname);     // Add a recipient
	
	
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = $altbody;
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
}


?>
