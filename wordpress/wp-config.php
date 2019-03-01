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
define( 'AUTH_KEY',         '):(^>ov|l47>TOHy70l`F5M~gLoZ^qpi`wikH3~E0?O4{qdC1{TIKD]7Q^G!ne0n' );
define( 'SECURE_AUTH_KEY',  '@Ky$wu:vY:TAIgQ&*f9x)R7&!>i<m eb}|;UD)$t0FO/kt<o39~&,]z+o-t$YAgw' );
define( 'LOGGED_IN_KEY',    '-uPr-;bi)m*exdmpO1&<nXb/_F!(nTKDZ.Yvt&$}{^;<d}dV+MG AEM?NVQ5k</j' );
define( 'NONCE_KEY',        'x4>Bm#.nrnc#%mEU|><pYOhb~93{-NQG,=>:u 66`oBvpws^q&N#]xTuulYKWSVi' );
define( 'AUTH_SALT',        '>PG:7#H%keD:&,dCZ5-CRQHMONI=5WYAa3p+$P+L!*k<c50=/F.mBg4Jr;K3gCV3' );
define( 'SECURE_AUTH_SALT', 'bnt(M(sq8j44hGOZVE|~P^K<+5}tazinbHUPY+=Yz&-mKFd;^`4v668jZYQa=vVB' );
define( 'LOGGED_IN_SALT',   '9i,&3H}Cpw@MG:| (K-xxv}iBi_Hm[5Cl>u,dUdcAZmxPl[[gmfg3~MPt&_F7kPn' );
define( 'NONCE_SALT',       'rqpzV]C2GY/:+{<gWd3Gz3sW-erP)eG&BWy=d!2fYWHjj`2}k!XpBKW{T{/x}A(R' );

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
