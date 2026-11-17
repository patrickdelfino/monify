<?php
/**
 * Carregando o painel
 *
 * @link              https://sarthemes.com/
 * @since             0.0.1
 * @package           monify/painel
 *
 */

if ( is_admin() ) {
    // Call Class
    include_once get_parent_theme_file_path('painel/assets.php');
    include_once get_parent_theme_file_path('painel/options.php');
    new STCode\Painel($options);
}