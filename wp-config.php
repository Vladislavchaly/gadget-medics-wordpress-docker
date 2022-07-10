<?php
define( 'WP_CACHE', false );    // Added by WP Rocket.

//Begin Really Simple SSL Load balancing fix
if ((isset($_ENV["HTTPS"]) && ("on" == $_ENV["HTTPS"]))
|| (isset($_SERVER["HTTP_X_FORWARDED_SSL"]) && (strpos($_SERVER["HTTP_X_FORWARDED_SSL"], "1") !== false))
|| (isset($_SERVER["HTTP_X_FORWARDED_SSL"]) && (strpos($_SERVER["HTTP_X_FORWARDED_SSL"], "on") !== false))
|| (isset($_SERVER["HTTP_CF_VISITOR"]) && (strpos($_SERVER["HTTP_CF_VISITOR"], "https") !== false))
|| (isset($_SERVER["HTTP_CLOUDFRONT_FORWARDED_PROTO"]) && (strpos($_SERVER["HTTP_CLOUDFRONT_FORWARDED_PROTO"], "https") !== false))
|| (isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && (strpos($_SERVER["HTTP_X_FORWARDED_PROTO"], "https") !== false))
|| (isset($_SERVER["HTTP_X_PROTO"]) && (strpos($_SERVER["HTTP_X_PROTO"], "SSL") !== false))
) {
$_SERVER["HTTPS"] = "on";
}
//END Really Simple SSL
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'gadgeto0_gadgetmedicsdb');
/** Имя пользователя MySQL */
define('DB_USER', 'gadgeto0_GMDB');
/** Пароль к базе данных MySQL */
define('DB_PASSWORD', "Atkqrn8FNZHn");
/** Имя сервера MySQL */
define('DB_HOST', 'mysql');
/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');
/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');
/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'sjBJ$fIQXon(iw6e%nzfZGHCug2?,SgNm<KmBhYo:{Z@A`T4+m7`fuVs~6{i._Cm');
define('SECURE_AUTH_KEY',  'oST3#q?TJ)7UqL N~a#u~N ]cThFACz}{CVGFpY6.$Jj$&u{P6]Rg7I9zrmtLHet');
define('LOGGED_IN_KEY',    'L{|;rd8ctyQU88&wH$.EZoaX.fvgx9ahLNCx^/w:`_!EfEqDsFb/Rz``ptK{u$z~');
define('NONCE_KEY',        'R{mNbm@$cJ|c496O%4Mh@X/#lWZoG39MB@6~6v,v}&9:Y0bEo-w_^L~Tmd1/F_Y,');
define('AUTH_SALT',        'gN.qc<J-Eg6EV,LOo#myC_0It*qYR-.D9_dk0aQgH9W_N$eBzr3Gz:ih.$u #<,D');
define('SECURE_AUTH_SALT', 'GrUWZ,SUQAhS8CS:/xuDoii</f6n$>k2iwGG>s:[ktSl$[P9%0cP@IF2DE tm_)>');
define('LOGGED_IN_SALT',   'O,I,/ uX49)9[vNlRmm_`C(p3hXq]V4 dYYmv>}yc X8C=Xf{]*ES WS),nfCpGE');
define('NONCE_SALT',       's[8mSeBBVSTWubN&4#h5%aceu<L`o+RvA2A&;KT?d#j2JSCQfZG&D*j&t|Q6lNjO');
/**#@-*/
/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';
/**

 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);
//svg
define( 'WPMS_ON', true );
define( 'WPMS_SMTP_PASS', 'your_password' );
define('ALLOW_UNFILTERED_UPLOADS', true);
define (‘ALLOW_UNFILTERED_UPLOADS’, true);

/* Это всё, дальше не редактируем. Успехов! */
/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
