<?php
/**
 * Importar os arquivos
 *
 * @link              https://sarthemes.com/
 * @since             0.0.1
 * @package           monify/inc
 *
 */

require get_parent_theme_file_path('inc/menu_home.php');
require get_parent_theme_file_path('inc/menu_footer.php');
require get_parent_theme_file_path('inc/assets.php');
require get_parent_theme_file_path('inc/functions.php');
require get_parent_theme_file_path('inc/register_sidebar.php');
require get_parent_theme_file_path('inc/database.php');
require get_parent_theme_file_path('inc/seo.php');
require get_parent_theme_file_path('inc/custom.php');
require get_parent_theme_file_path('inc/library/blog.php');
require get_parent_theme_file_path('inc/library/seguimentos.php');
require get_parent_theme_file_path('inc/library/cartao-de-credito.php');
require get_parent_theme_file_path('inc/library/conta-digital.php');
require get_parent_theme_file_path('inc/library/emprestimo.php');
//require get_parent_theme_file_path('inc/library/questionarios.php');
require get_parent_theme_file_path('inc/library/registros.php');
require get_parent_theme_file_path('inc/library/taxonomys.php');
/* Painel */
require get_parent_theme_file_path('painel/init.php');
/* Sitemap */
new STCode\Sitemap();
/* Shortcode */
new STCode\Shortcode();