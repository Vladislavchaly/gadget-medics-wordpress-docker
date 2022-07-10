<?php

$link = mysql_connect(
    "mysql",
    "gadgeto0_GMDB",
    "Atkqrn8FNZHn",
    $new_link = false,
    $client_flags = 0
);
if (!$link) {
    die('Ошибка соединения: ' . mysql_error());
}
mysql_close($link);
die('Успешно соединились');

//var_dump(mysqli_connect(
// ini_get("mysql"),
//ini_get("gadgeto0_GMDB"),
//ini_get("Atkqrn8FNZHn"),
//$new_link = false,
//$client_flags = 0
//));

/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define( 'WP_USE_THEMES', true );

/** Loads the WordPress Environment and Template */
require __DIR__ . '/wp-blog-header.php';
