<?php
/* blocking old code */
/*include('SMTPconfig.php');*/
/*include('SMTPClass.php');*/
/* end section blocking old code */

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	/* blocking old code */
	/*$to = $_POST['to'];
	$from = $_POST['from'];
	$subject = $_POST['sub'];
	$body = $_POST['message'];
	$SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $subject, $body);
	$SMTPChat = $SMTPMail->SendMail();*/
	/* end section blocking old code */

	require 'PHPMailerAutoload.php';

	$mail = new PHPMailer;

	$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'email-smtp.us-east-1.amazonaws.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'AKIAIWGOC3JYHQXJHYJA';                 // SMTP username
	$mail->Password = 'Ans0ELSec8JvU7A8kDIHoTReXqdDvxx13wam3xlTosWH';                           // SMTP password
	$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;                                    // TCP port to connect to

	$mail->From = 'talktous@buynbrag.com';
	$mail->FromName = 'BuynBrag';
	$mail->addAddress( $_POST['to'] );     // Add a recipient
	$mail->addReplyTo('talktous@buynbrag.com', 'BuynBrag');
	$mail->addCC('sam@buynrbag.com');
	$mail->addBCC('ashish@corewebconnections.com');

	$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $_POST['sub'];
	$mail->Body    = $_POST['message'];
	$mail->AltBody = $_POST['message'];

	if(!$mail->send()) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
	    echo 'Message has been sent';
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form method="post" action="">
<table width="500px">
<tr><td width="20%">To : </td>
<td ><input type="text" name="to" /></td></tr>
<tr><td>From :</td><td><input type='text' name="from" /></td></tr>
<tr><td>Subject :</td><td><input type='text' name="sub" /></td></tr>
<tr><td>Message :</td><td><textarea name="message"></textarea></td></tr>
<tr><td></td><td><input type="submit" value=" Send " /></td></tr>
</table>
</form>
</body>
</html>
