<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
//require 'vendor/autoload.php';
require __DIR__ . "/src/PHPMailer.php";
require __DIR__ . "/src/SMTP.php";
require __DIR__ . "/src/Exception.php";

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
	//Server settings
	//    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
	$mail->isSMTP(); //Send using SMTP
	$mail->Host = "smtp.mail.com"; //Set the SMTP server to send through
	$mail->SMTPAuth = true; //Enable SMTP authentication
	$mail->Username = "sender_email"; //SMTP username
	$mail->Password = "***********"; //SMTP password
	// $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	$mail->SMTPSecure = "ssl";
	$mail->Port = 465; //587                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	// $mail->SMTPDebug = 1;
	//Recipients
	$mail->setFrom("sender_email", "Sender's name"); //admin@fenki.net
	$mail->addAddress("reciever_email", "Reciever's Name"); //Add a recipient
	$mail->addAddress("reciever_email2", "Another reciever's name"); //Add a recipient
	// $mail->addAddress('reciever_email3'); //Name is optional

	// $mail->addReplyTo('sender_email', 'Sender Name');

	// $mail->addCC('reciever_email4');
	// $mail->addBCC('reciever_email5');
	$mail->MessageID =
		"<" .
		md5("HELLO" . (idate("U") - 1000000000) . uniqid()) .
		"-" .
		$type .
		"-" .
		$id .
		"@fenki.net>";
	$mail->CharSet = "UTF-8";
	//Attachments
	// $mail->addAttachment(
	// ); //Add attachments

	//Content
	$mail->isHTML(true); //Set email format to HTML
	$mail->Subject = "Mail subject";
	$body = file_get_contents(dirname(__DIR__) . "/mail_template.html");
	// $img = base64_encode(file_get_contents(__DIR__.'/Fenki_Words.jpg'));
	$mail->AddEmbeddedImage(
		dirname(__DIR__) . "/Fenki_Words.jpg",
		"Fenki_Words.jpg"
	);
	$body = str_replace(
		"<tr><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td></tr>",
		'<tr><td style="padding: 10px 10px; font-size:40px;font-weight: bold; border-radius: 6px;width: 30px;">5</td><td style="padding: 10px 10px; font-size:40px;font-weight: bold; border-radius: 6px;width: 30px;">3</td><td style="padding: 10px 10px; font-size:40px;font-weight: bold; border-radius: 6px;width: 30px;">2</td><td style="padding: 10px 10px; font-size:40px;font-weight: bold; border-radius: 6px;width: 30px;">1</td><td style="padding: 10px 10px; font-size:40px;font-weight: bold; border-radius: 6px;width: 30px;">6</td><td style="padding: 10px 10px; font-size:40px;font-weight: bold; border-radius: 6px;width: 30px;">7</td></tr>',
		$body
	);
	$mail->Body = $body;
	//$mail->Body =
	$mail->AltBody = "Fenki words OTP password is 532167";
	// die($body);
	$mail->send();
	echo "Message has been sent";
} catch (Exception $e) {
	// if ($mail->ErrorInfo == "SMTP Error: Could not authenticate.")
	// echo "Auth problem detected\n\n";
	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
