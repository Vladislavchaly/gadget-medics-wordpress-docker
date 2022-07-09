<?php

var_dump($_POST);
//$custom_path = "http://gadgetmedics.com/uploads-cst/";
if ((!empty($_POST))&&(isset($_SERVER['HTTP_X_REQUESTED_WITH']))&&($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
header('Content-Type: application/json; charset=utf-8');
$response = array();
$img = '';
$response['status'] = 'bad';
if (!empty($_FILES['file']['tmp_name'])){
    for($key=0;$key<count($_FILES['file']['tmp_name']);$key++){
        $upload_path = __DIR__ . "/uploads-cst/";
        $user_filename = $_FILES['file']['name'][$key];
        $userfile_basename = pathinfo($user_filename,PATHINFO_FILENAME );
        $userfile_extension = pathinfo($user_filename, PATHINFO_EXTENSION);
        $server_filename = $userfile_basename . "." . $userfile_extension;
        $server_filepath = $upload_path . $server_filename;
        $html = "<img style='width: 300px!important' src='http://gadgetmedics.com/uploads-cst/$server_filename'/>";
        $i = 0;
        while(file_exists($server_filepath)){
            $i++;
            $server_filepath = $upload_path .  $userfile_basename . "($i)." . $userfile_extension;
        }
        if (copy($_FILES['file']['tmp_name'][$key], $server_filepath)){
            $response['files'][] =  $server_filepath;
            $response['status'] = 'ok';
        }
        $img .=$html;
        $html  = '';
    }
}
echo json_encode($response);
$username =  $_POST['username'];
$phone =  $_POST['phone'];
$email =  $_POST['e-mail'];
$device =  $_POST['device'];
$storage =  $_POST['storage'];
$carrier = $_POST['carrier'];

$powerOn = $_POST['powerOn'];
$fullyLightUp = $_POST['fullyLightUp'];
$fullyFunctional = $_POST['fullyFunctional'];
$scratchesAnywhere = $_POST['scratchesAnywhere'];
$cracksAnywhere = $_POST['cracksAnywhere'];
require 'PHPMailer-5.2-stable/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.mail.ru';                         // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'kar.1295@mail.ru';                 // SMTP username
$mail->Password = '094286364ml';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->setFrom('kar.1295@mail.ru', 'Mailer');
$mail->addAddress('kar.1295@mail.ru');               // Name is optional
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//
//$mail->addAttachment($custom_path);         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'Name:  '.$username.'<br/>'.
    'Phone:  '.$phone.'<br/>'.
    'Email:  '.$email.'<br/>'.
    'Device:  '.$device.'<br/>'.
    'Storage:  '.$storage.'<br/>'.
    'Carrier:  '.$carrier.'<br/>'.
    'Does the device power on?  :  '.$powerOn.'<br/>'.
    'Does the screen fully light up?  :  '.$fullyLightUp.'<br/>'.
    'Is your device fully functional?  :  '.$fullyFunctional.'<br/>'.
    'Are there scratches anywhere?  :  '.$scratchesAnywhere.'<br/>'.
    'Are there cracks anywhere?  :  '.$cracksAnywhere.'<br/>'
    .$img;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
?>