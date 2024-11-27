<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/home/187653.cloudwaysapps.com/epetjkrrgu/public_html/wp-content/plugins/wp-super-cache/' );
define('FS_METHOD','direct');
define('DB_NAME', 'epetjkrrgu');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'epetjkrrgu');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', '3RcpSarX9X');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'R2M:mImp >JE%$am1TXl$N8~<*^.cf`[-}lJ)]PlYMgoL)K@*O>t8#|i]v]1cMs4');
define('SECURE_AUTH_KEY', 'lIgMMjDO(CXL+:%ZsF=Y Rz8X/f<BDZ|pJ}9_9UR<e(tM~b /Dw^xFyXN=TzKntW');
define('LOGGED_IN_KEY', '~TYPjBxviWxL7#ep&4<BQE@^G35~/#HyVy9?L}Wi#fATNhAZCEPV],}grozUlw`!');
define('NONCE_KEY', ' xtary2Z)GZIby$XC>A!6;XFX$Y s|JfTZ<E9Nwf/gY0]5EtYsQPI{[cG(!lO^uH');
define('AUTH_SALT', 'A;|Q}Esaz]W:5z8j99wzm;8ZE1,s{Y&T4=j5r(*SfT|{DJQJ~$ywsNTzf#m%#~I:');
define('SECURE_AUTH_SALT', '1|F;ZWmU=6je_:rxm;to$qi(D_(8m}8%J SMyU;_z*eoN=}BaiYF)acQctLc&h9k');
define('LOGGED_IN_SALT', 'sV?AEmOEp3bQa|gEdrl0DBTk&{/aFp52W|_Xd8hb]cG0O6cR/7I(|X0O^Dv|#O62');
define('NONCE_SALT', '$Dy@u]}D5ugQr3om2!W83Jhs1`4_68TeOA,CVT#XloCA,fT|nU9?luQ-yh0c,q%t');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'w0lap_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

