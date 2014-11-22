<?php
$to      = 'mwnt.test11@gmail.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: info@buynbrag.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

if(mail($to, $subject, $message, $headers)) echo 'sent'; else echo 'not sent';
?>