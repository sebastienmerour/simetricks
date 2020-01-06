<?php
$status = "";
$subject = "Demande de ré-initialisation de mot de passe";
$body ='<p>Congratulations!</p>';
$body .='<p>You have successfully received an email from
<a href="https://www.simetricks.com/">Simetricks.com</a>.</p>';
// Enter Your Email Address Here To Receive Email
$email_to = "your_email@domain.com";

$email_from = "noreply@domain.com"; // Enter Sender Email
$sender_name = "AllPHPTricks"; // Enter Sender Name
require("PHPMailer/PHPMailerAutoload.php");
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = " smtp.mailtrap.io"; // Enter Your Host/Server
$mail->SMTPAuth = true;
$mail->Username = "e2ba656157aa9b"; // Enter Sender Email
$mail->Password = "b48f6403df97b3";
//If SMTP requires TLS encryption then remove comment from it
//$mail->SMTPSecure = "tls";
$mail->Port = 25;
$mail->IsHTML(true);
$mail->From = $email_from;
$mail->FromName = $sender_name;
$mail->Sender = $email_from; // indicates ReturnPath header
$mail->AddReplyTo($email_from, "No Reply"); // indicates ReplyTo headers
$mail->Subject = $subject;
$mail->Body = $body;
$mail->AddAddress($email_to);
// If you know receiver name using following
//$mail->AddAddress($email_to, "Recepient Name");
// To send CC remove comment from below
//$mail->AddCC('username@email.com', "Recepient Name");
// To send attachment remove comment from below
//$mail->AddAttachment('files/readme.txt');
/*
Please note file must be available on your
host to be attached with this email.
*/

if (!$mail->Send()){
	$status = "Mailer Error: " . $mail->ErrorInfo;
	}else{
	$status = "<div style='color:#FF0000; font-size:20px; font-weight:bold;'>
	An email has been sent to your email address.</div>";
}
?>

<html>
<head>
<title>Send Email in PHP Using PHPMailer - AllPHPTricks.com</title>
</head>
<body>
<?php echo $status; ?>
<br /><br />
<a href="https://www.allphptricks.com/send-email-in-php-using-phpmailer/">Tutorial Link</a> <br /><br />
For More Web Development Tutorials Visit: <a href="https://www.allphptricks.com/">AllPHPTricks.com</a>
</body>
</html>
