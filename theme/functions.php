<?php
/**
 * O arquivo de inicialização do tema
 *
 * @link              https://sarthemes.com/
 * @since             0.0.1
 * @package           monify
 *
 */

/**
* Define as diretorias do site
*
* @since    0.0.1
*/
define('STCODE_URI', get_template_directory_uri());
define('STCODE_DIR', get_template_directory());
define('STCODE_VER', '0.0.1');
define('STCODE_OPTIONS', 'stcodes_options');

/**
* Puxa os arquivos importante para trabalhar no tema
*
* @since    0.0.1
*/
require_once( STCODE_DIR . '/vendor/autoload.php');
require_once( STCODE_DIR . '/inc/init.php');