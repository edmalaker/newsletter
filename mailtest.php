<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
//This needs to be changed to your specific host
require '../../vendor/autoload.php';

//This needed to be changed on mine to what I have here
$mail = new \PHPMailer;


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
	
	
    
	$mail->addAddress('edmalaker@gmail.com', 'Joe User');     // Add a recipient
	//$mail->addAddress('ellen@example.com');               // Name is optional
	
	
    //$mail->addReplyTo('info@example.com', 'information');   //add secondary email, cc, and bcc if needed
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments if needed
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}