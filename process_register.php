<?php

use PSpell\Config;

    include("email/EmailSender.php");
    include("email/EmailServerInterface.php");
    include("email/MyEmailServer.php");
    include("config.php");
    function rounddd(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
    $code= '';
    for ($i = 0; $i < 40; $i++) {
        $code .= $characters[rand(0, strlen($characters))];
    };
    return $code;
    }
   




if(isset( $_POST['send'])){
$emailServer = new MyEmailServer();
$emailSender = new EmailSender($emailServer);
$ma=rounddd();
$emailSender->send($_POST['email'], "Xac thuc Email", $ma);


$db_host = 'localhost';
$db_name = 'email_user';
$db_user = 'root';
$db_pass = '';

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$conn = mysqli_connect('localhost', 'root', '', 'email_user');
$email = $_POST['email'];
$pass=$_POST['pass'];
$query = "INSERT INTO users(email ,password	,activation,status) VALUES ('$email','$pass', '$ma',0)";

if(mysqli_query($conn,$query)){
   echo "TRue";
 }
 else echo "Loi";
}

?>