<?php
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
define( 'DB_NAME', 'cafe' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'root' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '*I&k+5;&KicKo~o:t{,mk^x_RK@WUq@#:eMd=~2^AzCfv^MuU$2f4dz,Xb/LlxP&' );
define( 'SECURE_AUTH_KEY',  'M&^6W1;Bz)kLL?5rP@>?Eq3TDE9`[L;GK^~a.5$w7#g8z}VgkKNl.r`8>)G{R)  ' );
define( 'LOGGED_IN_KEY',    'G:zV582cZN{G;H:_IgRV_IdSvj{ayD IRdJxhkl$s$wqxsL3u4-C|ZzKoyqO8#wb' );
define( 'NONCE_KEY',        'Q1ELA9nQT=P!W9TFD0.]MBFP0o=C(*x<k$}u^+ jjp<{;.vcDJ9aju].N6MLyq@[' );
define( 'AUTH_SALT',        'XVKR$YG<9&`rhhmHk0buaJn#x{8B./dmTt{{5$WN3$Q]$YaEX(p`fc-^)G}&2;`y' );
define( 'SECURE_AUTH_SALT', '[(Xzg&0%|4QNgqdFp%ig#64yww:v9r=K2|i|Ha],c_F`@u>sy~pb?XCdq._d)Eap' );
define( 'LOGGED_IN_SALT',   'yc6Kas<?lirOLYnq{J({1=XEzWfzogz]Mg7AoUtA.6S.Wwk+k%;v+fvv_;$TPOG ' );
define( 'NONCE_SALT',       ']F0|^q|Aeqd.<lnwvG5,QMtiV#18ec52X`q,6S9)LvbOP53:e%_EOe0Qmo2n7W@<' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
