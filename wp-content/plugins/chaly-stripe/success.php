<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
global $wpdb, $wp_version;
//
//$query =  "SELECT * FROM `wp_request_form_chaly` WHERE `id` = ";
//$children = $wpdb->get_results($query);
//
//print_r($children);
//unset($query);
//$query = "INSERT INTO `wp_request_form_chaly` (`id`, `name`, `phone`, `email`, `model`, `color`, `pay_status`) VALUES (NULL, 'test1', '380667074533', 'test@gmail.com', 'test', 'test', '1')";
//$query = $wpdb->query($query);
//$id = $wpdb->insert_id;
//echo $id;
//print_r($query);

if (isset($_GET['request_pay_id'])) {

    $query =  "SELECT * FROM `wp_request_form_chaly` WHERE `id` =".$_GET['request_pay_id'];
    $children = $wpdb->get_results($query);
     $webhook =   "https://hooks.slack.com/services/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"; // online
//    $webhook = "https://hooks.slack.com/services/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";
    $name = $children[0]->name;
    $phone = $children[0]->phone;
    $email = $children[0]->email;
    $model = $children[0]->model;
    $color = $children[0]->color;
    $payment = $children[0]->pay_status;
    $message = "
    iPhone Back Glass Repair
    \n
    Name: $name;\n
    Phone: $phone; \n
    Eamil: $email;\n
    Model: $model;\n
    Color: $color;\n
    Payment: $payment;\n
    ";
     api_gadgetMedics_request($webhook, ["text" => $message]);
    header("Location: /");
}