<?php 
$emailServer = new MyEmailServer();
$emailSender = new EmailSender($emailServer);
$emailSender->send("thangchien86@gmail.com", "Test Email", "This is a test email.");