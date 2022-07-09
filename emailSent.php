<?php
require(__DIR__ . '/wp-load.php');

//footer form
$to = 'kar.1295@mail.ru';
$subject = 'Gadget Medics';
$message = 'Имя:   '.$_POST['username']."\r\n".'Номер Телефона:   '.$_POST['phone']."\r\n".'Email:   '.$_POST['email'];
$headers = 'Заявки с сайта';
wp_mail($to, $subject, $message, $headers);
