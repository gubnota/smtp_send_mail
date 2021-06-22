<?php
require_once "vendor/autoload.php";

// Create the Transport
$transport = (new Swift_SmtpTransport("smtp.email.com", 587, "tls"))
	->setUsername("sender_mail")
	->setPassword("**** email password ****");

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message("Mail subject"))
	->setFrom(["sender_mail" => "Sender Name"])
	->setTo(["reciever_mail"]) //'someone@gmail.com' => 'Mr.Name'
	->setBody(file_get_contents(dirname(__DIR__) . "/mail_template.html")) //first create this html template
	->setContentType("text/html");
// ->attach(Swift_Attachment::fromPath(__DIR__.'/img.png'))
$message->setReplyTo(["sender_mail" => "Sender Name"]);
// Send the message
try {
	$result = $mailer->send($message);
	print "The message has been sent.";
} catch (\Throwable $th) {
	print "The message hasn't been sent.";
	//  print_r($th->message);//Swift_TransportException Object
	//message:protected] => Failed to authenticate on SMTP server with username "surielena1992w@gmail.com" using 3 possible authenticators. Authenticator LOGIN returned Expected response code 235 but got code "535", with message "535-5.7.8 Username and Password not accepted. Learn more at
}
