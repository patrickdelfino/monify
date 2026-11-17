<?php
/**
 *
 * Arquivos para o front do site
 * @link https://sarthemes.com/
 * @since 0.0.1
 * @package monify/inc/
 *
 */

/* Carrega as folhas de estilos e de javascripts */
function stcodes_assets() {
    global $wp;
    $current_url = add_query_arg(array(), $wp->request);
    
    /* Theme Style */
    if (is_home() && !is_stcode_template()) {
	    wp_enqueue_style( 'monify-theme', STCODE_URI . '/assets/css/stcode.home.css', false, STCODE_VER );
	} else {
        wp_enqueue_style( 'monify-theme', STCODE_URI . '/assets/css/stcode.default.css', false, STCODE_VER );
    }
    if (is_stcode_template_single()) {
        wp_enqueue_style( 'monify-theme-single', STCODE_URI . '/assets/css/stcode.single.css', false, STCODE_VER );
    }
    if (is_stcode_template_single()) {
        wp_enqueue_script( 'monify-card-shortcode', STCODE_URI . '/assets/js/monify.cartao.js', array( 'jquery' ), STCODE_VER, true );
        wp_localize_script('monify-card-shortcode', 'STCode', array(
            // Importar
            'homeurl'      => get_home_url(),
        ));
    }
    if (is_stcode_archive_list()) {
        wp_enqueue_script('monify-list-archive', STCODE_URI . '/assets/js/monify.archivelist.js', [], filemtime(STCODE_DIR . '/assets/js/monify.archivelist.js'), true);
    }
    if (trim($wp->request, '/') === 'comparador-de-cartao-de-credito/comparar') {
        wp_enqueue_script('monify-comparison', STCODE_URI . '/assets/js/monify.comparador.js', [], filemtime(STCODE_DIR . '/assets/js/monify.comparador.js'), true);
    }
    $responsive_dependencies = wp_style_is('monify-theme-single', 'enqueued') ? ['monify-theme', 'monify-theme-single'] : ['monify-theme'];
    wp_enqueue_style('monify-responsive', STCODE_URI . '/assets/css/stcode.responsive.css', $responsive_dependencies, filemtime(STCODE_DIR . '/assets/css/stcode.responsive.css'));
    /* FontAwesome */
    wp_enqueue_style( 'monify-boxicons', STCODE_URI . '/assets/fonts/boxicons/css/boxicons.min.css', false, STCODE_VER );
    wp_enqueue_style( 'monify-outfit', STCODE_URI . '/assets/fonts/outfit/outfit.css', false, STCODE_VER );
    /* Slide */
    
    if (!is_stcode_template()) {
        wp_enqueue_script( 'monify-theme', STCODE_URI . '/assets/js/monify.min.js', array( 'jquery' ), STCODE_VER, true );
        wp_localize_script('monify-theme', 'STCode', array(
            // Importar
            'ajaxurl'       => admin_url('admin-ajax.php', 'relative'),
            'themeurl'      => STCODE_URI,
            'homeurl'      => get_home_url(),
            'loading'       => 'Carregando...'
        ));
    }

    if (trim($wp->request, '/') !== 'blog') {
        global $wp_query;

        $posts = json_encode( $wp_query->query_vars );
        $max_page = $wp_query->max_num_pages;

        wp_enqueue_script( 'load-more', get_template_directory_uri() . '/assets/js/load-more.js', array('jquery'), '1.0', true );
        wp_localize_script( 'load-more', 'loadmore_params', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'posts' => $posts,
            'cur_page' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
            'max_page' => $max_page,
        ));
    } else {
        wp_enqueue_script( 'load-more', get_template_directory_uri() . '/assets/js/loadmore-blog.js', array('jquery'), filemtime(STCODE_DIR . '/assets/js/loadmore-blog.js'), true );
        wp_localize_script( 'load-more', 'loadmore_params', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
        ));
    }
}

add_action('wp_enqueue_scripts', 'stcodes_assets');

function load_custom_css_in_admin() {
    wp_enqueue_media();
    /* Selectize */
    wp_enqueue_style( 'stcode-selectize', 'https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/css/selectize.default.css' );
    wp_enqueue_script( 'selectize', 'https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/js/standalone/selectize.min.js', array( 'jquery' ), time(), true );
    // Se a classe estiver presente, carrega o arquivo CSS
    wp_enqueue_style('stcode-metafields-admin-css', STCODE_URI . '/assets/css/stcode.meta.css');
    wp_enqueue_style('stcode-icons-css', STCODE_URI . '/assets/css/stcode.admin.icon.css');
    // Javascript princial
    wp_enqueue_script( 'monify-admin', STCODE_URI . '/assets/js/stcode.admin.js', array( 'jquery' ), time(), false );
    // Seo
    wp_enqueue_style( 'stcode-seo', STCODE_URI . '/assets/css/stcode.seo.css' );
    wp_enqueue_script( 'stcode-seo', STCODE_URI . '/assets/js/stcode.seo.js', array(), time(), true );
}

add_action('admin_enqueue_scripts', 'load_custom_css_in_admin');

