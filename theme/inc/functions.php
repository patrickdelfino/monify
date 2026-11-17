<?php
/**
 * Inicialização de funções
 *
 * @link              https://sarthemes.com/
 * @since             0.0.1
 * @package           monify/inc
 *
 */


/**
* WP Funções customizadas
*
* @since    0.0.1
* @var      string      $name_folder_plugin
*/

/* Remover Logo do Toolbar */
function toolbaredit($wp_toolbar) {
	$wp_toolbar->remove_node('wp-logo');
}
add_action('admin_bar_menu', 'toolbaredit', 999);

/* Mudar <title> WP-admin */
function adminTitle( $admin_title ) {
    return str_replace( '&#8212; WordPress', '&#8212; Desenvolvido por: Sarthemes', $admin_title );
}
add_filter( 'admin_title', 'adminTitle' );

/* Mudar Rodapé da administração */
function footerInfo () {
    echo "Desenvolvido por: SarThemes";
}
add_filter('admin_footer_text', 'footerInfo');

/* Remover os suporte de imagem padrão do wordpress */
function namespace_disable_image_sizes($sizes)
{
    unset($sizes['thumbnail']);    // disable thumbnail size
    unset($sizes['medium']);       // disable medium size
    unset($sizes['large']);        // disable large size
    unset($sizes['medium_large']); // disable medium-large size
    unset($sizes['1536x1536']);    // disable 2x medium-large size
    unset($sizes['2048x2048']);    // disable 2x large size

    return $sizes;
}
add_action('intermediate_image_sizes_advanced', 'namespace_disable_image_sizes');

// disable scaled image size
add_filter('big_image_size_threshold', '__return_false');

// disable rotated image size
add_filter('wp_image_maybe_exif_rotate', '__return_false');

// disable other image sizes
function namespace_disable_other_image_sizes()
{
    remove_image_size('post-thumbnail'); // disable images added via set_post_thumbnail_size()
    remove_image_size('another-size');   // disable any other added image sizes
}
add_action('init', 'namespace_disable_other_image_sizes');

/* Definir os suporte padrão wordpress */
function theme_setup() {
    // Suportes
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    // Menus
    register_nav_menus( 
        array(
            'menu-home' => __('Menu Home', 'stcodes'),
            'menu-singles' => __('Menu Single', 'stcodes'),
            'footer-1' => __('Footer 1', 'stcodes'),
            'footer-2' => __('Footer 2', 'stcodes'),
            'footer-3' => __('Footer 3', 'stcodes'),
            'footer-4' => __('Footer 4', 'stcodes'),
            'footer-5' => __('Footer 5', 'stcodes')
        ) 
    );
    // Images
    add_image_size('4096w', 4096, 0);
    add_image_size('3200w', 3200, 0);
    add_image_size('2560w', 2560, 0);
    add_image_size('1920w', 1920, 0);
    add_image_size('1600w', 1600, 0);
    add_image_size('1280w', 1280, 0);
    add_image_size('1140w', 1140, 0);
    add_image_size('1024w', 1024, 0);
    add_image_size('960w', 960, 0);
    add_image_size('800w', 800, 0);
    add_image_size('768w', 768, 0);
    add_image_size('640w', 640, 0);
    add_image_size('425w', 425, 0);
    add_image_size('320w', 320, 0);
    add_image_size('240w', 240, 0);
}
add_action('after_setup_theme', 'theme_setup');

/**
* WP Mudar o permalink da pesquisa ?s= sera /search/nome-da-pesquisa
*
* @since    0.0.1
*/
function change_search_url() {
    if ( is_search() && ! empty( $_GET['s'] ) ) {
        $filters = isset($_GET) ? $_GET : array();
        unset($filters['s']);
        $query_string = array();

        foreach ($filters as $k => $v) {
            $query_string[] = "$k=".urlencode($v);
        }

        wp_redirect( home_url( "/search/" ) . urlencode( get_query_var( 's' ) ) . '?' . implode('&', $query_string) );
        exit();
    }
}
add_action( 'template_redirect', 'change_search_url' );

/**
* Buscar postagem mais vistas [conteúdo popular]
*
* @since    0.0.1
*/
function post_orderby_populares($orderby, $qry) {

    global $wpdb;

    $sub = $qry->get('order_popular');

    $order = $qry->get('order');

    if (!empty($sub)) {

        $orderby = "v.pageviews $order";

    }

    return $orderby;

}
add_filter('posts_orderby', 'post_orderby_populares', 1, 2);

function post_join_populares( $join, $qry ){
    global $wpdb;
    $sub = $qry->get('order_popular');
    if (!empty($sub)) {
        $join .= "INNER JOIN `{$wpdb->prefix}stcode_post_views` v ON $wpdb->posts.ID = v.postid";
    }
    return $join;
}
add_filter( 'posts_join', 'post_join_populares', 10, 2 );

/**
* Verifica uma data seja array multimensional ou um parametro
*
* @since    0.0.1
*/
function verifyData($data, $meta){
    return isset($data[$meta]) ? $data[$meta] : false;
}

/**
* Verifica um parametro com isset caso verdadeiro retorna o valor senao o false
*
* @since    0.0.1
*/
function stcode_meta_isset($data, $meta){
    return (isset($data[$meta][0])) ? $data[$meta][0] : false;
}

/**
* Buscar uma opção salva no STCODE_OPTIONS array multimensional
*
* @since    0.0.1
*/
function stcode_get_option($option_name = '', $default = ''){
    $options = apply_filters('stcode_get_option', get_option(STCODE_OPTIONS), $option_name, $default);
    if(!empty($option_name) && ! empty($options[$option_name])){
        return $options[$option_name];
    } else {
        return (!empty($default)) ? $default : null;
    }
}

/**
* Salva uma informação no STCODE_OPTIONS array multimensional
*
* @since    0.0.1
*/
function stcode_set_option($option_name = '', $new_value = ''){
    $options = apply_filters('stcode_set_option', get_option(STCODE_OPTIONS), $option_name, $new_value);
    if(!empty( $option_name )) {
        $options[$option_name] = $new_value;
        update_option(STCODE_OPTIONS, $options);
    }
}

/**
* Verfificar de PostMeta
*
* @since    0.0.1
*/
function stcode_meta($value , $id) {
    $field = get_post_meta( $id, $value, true );
    if ( ! empty( $field ) ) {
        return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
    } else {
        return false;
    }
}

/**
* Modo de manutenção do site
*
* @since    0.0.1
*/
if(!function_exists('stcode_offline_mode')) {
    function stcode_offline_mode(){
        if(!current_user_can('edit_themes') || !is_user_logged_in() ){
            // die Website
            wp_die( stcode_get_option('offline_message'), 'Site em manutenção!', array('response' => 200));
            // Exit
            exit;
        }
    }
    if(stcode_get_option('ativar_manutencao','false') !== 'false'){
        add_action('get_header', 'stcode_offline_mode');
    }
}

/* Remove link cononical do wp */
remove_action('wp_head', 'rel_canonical');

/**
* Retorna as string mudada de acordo com o nome
*
* @since    0.0.1
*/
function stcode_change_tags($frase)
{
    $encontrar = [];
    $trocar = [];

    // Substituições diretas
    if (strpos($frase, '{site_name}') !== false) {
        $encontrar[] = '{site_name}';
        $trocar[] = get_bloginfo('name');
    }

    if (strpos($frase, '{site_descricao}') !== false) {
        $encontrar[] = '{site_descricao}';
        $trocar[] = get_bloginfo('description');
    }

    if (strpos($frase, '{separador}') !== false) {
        $encontrar[] = '{separador}';
        $trocar[] = ' - ';
    }

    if (strpos($frase, '{post_name}') !== false) {
        $encontrar[] = '{post_name}';
        $trocar[] = get_the_title();
    }

    if (strpos($frase, '{post_excerpt}') !== false) {
        $encontrar[] = '{post_excerpt}';
        $trocar[] = get_the_excerpt();
    }

    if (strpos($frase, '{category_name}') !== false) {
        $encontrar[] = '{category_name}';
        $trocar[] = esc_html(single_cat_title('', false));
    }

    if (strpos($frase, '{category_excerpt}') !== false) {
        $encontrar[] = '{category_excerpt}';
        $trocar[] = wp_kses_post(category_description());
    }

    if (strpos($frase, '{tag_name}') !== false) {
        $encontrar[] = '{tag_name}';
        $trocar[] = esc_html(single_tag_title('', false));
    }

    if (strpos($frase, '{tag_excerpt}') !== false) {
        $encontrar[] = '{tag_excerpt}';
        $trocar[] = wp_kses_post(tag_description());
    }

    // Substituições dinâmicas com regex
    if (strpos($frase, '{category:') !== false) {
        preg_match_all('/\{category:(\d+)\}/', $frase, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $encontrar[] = $match[0];
            $category_id = $match[1];
            $category = get_category($category_id);
            $trocar[] = $category ? $category->name : '';
        }
    }

    if (strpos($frase, '{tag:') !== false) {
        preg_match_all('/\{tag:(\d+)\}/', $frase, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $encontrar[] = $match[0];
            $tag_id = $match[1];
            $tag = get_tag($tag_id);
            $trocar[] = $tag ? $tag->name : '';
        }
    }

    // Realiza as substituições
    return str_replace($encontrar, $trocar, $frase);
}

/**
* Paginação das postagens
*
* @since    0.0.1
*/
function pagination($total_pages = '') {

    global $paged,$pagina;
    $current_page = 1;
    if(!empty($paged)) {
        $current_page = $paged;
    } else if(!empty($pagina)) {
        $current_page = $pagina;
    }

    if($total_pages == '') {
        global $wp_query;
        $total_pages = $wp_query->max_num_pages;
        if(!$total_pages) { 
            $total_pages = 1; 
        }
    }

    $links = "";
    if ($total_pages > 1 && $current_page <= $total_pages) {
        $links .= '<ul class="content-pagination b_flex b_wrap">';
        $nextpage = (int)($current_page + 1);
        $prevpage = (int) $current_page - 1;

        if ( $prevpage < 1 ) {
            $prevpage = 1;
        }

        if ($current_page != 1) {
            $prev = get_pagenum_link( $prevpage );
            $divP = '<li class="prev"><a href="'.$prev.'"></a>';
            $links .= $divP.'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9.8 14" class="mp-icon arrow-icon left replaced-svg"><path d="M0.6 0.6c-0.8 0.8-0.8 2 0 2.8L4.2 7l-3.6 3.6c-0.8 0.8-0.8 2 0 2.8C1 13.8 1.5 14 2 14s1-0.2 1.4-0.6L9.8 7 3.4 0.6C2.6-0.2 1.4-0.2 0.6 0.6z"></path></svg></li>';
        }

        $links .= "<li".(($current_page == 1) ? ' class="active"' : null)."><a href=\"".get_pagenum_link(1)."\">1</a><span>1</span></li>";

        $i = max(2, $current_page - 5);
        if ($i > 2) {
            $links .= "<li><a href=\"#\" onclick=\"return false;\">...</a><span>...</span></li>";
        }

        for (; $i < min($current_page + 6, $total_pages); $i++) {
            $links .= "<li".(($current_page == $i) ? ' class="active"' : null)."><a href=\"".get_pagenum_link($i)."\">".$i."</a><span>".$i."</span></li>";
        }

        if ($i != $total_pages){
            $links .= "<li><a href=\"#\" onclick=\"return false;\">...</a><span>...</span></li>";
        }

        $links .= "<li ".(($current_page == $total_pages) ? ' class="active"' : null)."><a href=\"".get_pagenum_link($total_pages)."\">".$total_pages."</a><span>".$total_pages."</span></li>";

        $next = '';
        if ( $total_pages >= $nextpage ) {
            $next = get_pagenum_link( $nextpage );
        }

        if (!empty($next)) {
            $divN = '<li class="next"><a href="'.$next.'"></a>';
            $links .= $divN.'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9.8 14" class="mp-icon arrow-icon replaced-svg"><path d="M0.6 0.6c-0.8 0.8-0.8 2 0 2.8L4.2 7l-3.6 3.6c-0.8 0.8-0.8 2 0 2.8C1 13.8 1.5 14 2 14s1-0.2 1.4-0.6L9.8 7 3.4 0.6C2.6-0.2 1.4-0.2 0.6 0.6z"></path></svg></li>';
        }

        $links .= '</ul>';
    }

    echo $links;
}

/**
* Identifica se a pagina atual necessidade de uma class para o body
*
* @since    0.0.1
*/
function stcode_classbody() {
    global $wp;
    $current_url = add_query_arg(array(), $wp->request);

    // Verifica se a URL corresponde ao padrão desejado
    if (preg_match('/comparador-de-cartao-de-credito/', $current_url) OR preg_match('/comparador-de-cartao-de-credito\/comparar/', $current_url, $matches)) {
        echo ' class="body-dark-gray"';
    } else if (preg_match('/cartoes\/([^\/]+)?$/', $current_url, $matches) OR preg_match('/emprestimos\/([^\/]+)?$/', $current_url, $matches) OR preg_match('/bancos\/([^\/]+)?$/', $current_url, $matches)) {
       echo ' class="body-ced"';
    }
}

/**
* Função de gerar tag no custom permalink
* @author https://wordpress.stackexchange.com/a/301193
*
* @since    0.0.1
*/

add_rewrite_tag( '%tipo_conteudo%', '(.+)', 'tipo_conteudo=' );

add_filter( 'available_permalink_structure_tags', function ( array $tags ) : array {
    $tags['tipo_conteudo'] = 'retorna o tipo de conteudo [cartao, emprestimo, conta-digital]';
    return $tags;
});

/**
* Função para trocar a tag na url pelo objetivo dela
*
* @since    0.0.1
*/
function stcode_post_permalink($permalink, $post) {
    if ( 'post' === $post->post_type ) {
        if (strpos( $permalink, '%tipo_conteudo%' ) !== false) {
            $artigo_tipo = stcode_artigoname(get_post_meta($post->ID, 'stcode_artigo_tipo', true));
            $permalink = str_replace( '%tipo_conteudo%', sanitize_title($artigo_tipo), $permalink);
        }
    }

    return $permalink;
}
add_filter('post_link', 'stcode_post_permalink', 10, 2);

/**
* Troca o permalink dos custompost
*
* @since    0.0.1
*/
function stcode_custom_post_permalink($permalink, $post, $leavename){
    if ($post->post_type === 'stcode_seguimentos') {
        $artigo_tipo = get_post_meta($post->ID, 'stcode_artigo_tipo', true);
        $post_cartao = get_post_meta($post->ID, 'stcode_cartao_escolhido', true);
        $post_emprestimo = get_post_meta($post->ID, 'stcode_emprestimo_escolhido', true);
        $post_digital = get_post_meta($post->ID, 'stcode_conta_digital_escolhido', true);
        $permalink = get_post_meta($post->ID, 'stcode_permalink', true);
        if ($artigo_tipo === 'cartao-de-credito' && $post_cartao != '') {
            $titulo = get_post_meta($post_cartao, 'titulo_original', true) !== '' ? get_post_meta($post_cartao, 'titulo_original', true) : get_the_title($post_cartao);
            $permalink = home_url('/cartoes/' . sanitize_title($titulo) . '/' . $permalink . '/');
        } elseif ($artigo_tipo === 'emprestimo' && $post_emprestimo != '' ) {
            $titulo = get_post_meta($post_emprestimo, 'titulo_original', true) !== '' ? get_post_meta($post_emprestimo, 'titulo_original', true) : get_the_title($post_emprestimo);
            $permalink = home_url('/'.$artigo_tipo.'s/' . sanitize_title($titulo) . '/' . $permalink . '/');
        } elseif($artigo_tipo === 'conta-digital' && $post_digital != '') {
            $titulo = get_post_meta($post_digital, 'titulo_original', true) !== '' ? get_post_meta($post_digital, 'titulo_original', true) : get_the_title($post_digital);
            $permalink = home_url('/bancos/' . sanitize_title($titulo) . '/' . $permalink . '/');
        }
    }

    if ($post->post_type === 'stcode_cartao') {
        $titulo = get_post_meta($post->ID, 'titulo_original', true) !== '' ? get_post_meta($post->ID, 'titulo_original', true) : get_the_title($post->ID);
        $permalink = home_url('/cartoes/' . sanitize_title($titulo). '/');
    }

    if ($post->post_type === 'stcode_emprestimo') {
        $titulo = get_post_meta($post->ID, 'titulo_original', true) !== '' ? get_post_meta($post->ID, 'titulo_original', true) : get_the_title($post->ID);
        $permalink = home_url('/emprestimos/' . sanitize_title($titulo) . '/');
    }

    if ($post->post_type === 'stcode_conta_digital') {
        $titulo = get_post_meta($post->ID, 'titulo_original', true) !== '' ? get_post_meta($post->ID, 'titulo_original', true) : get_the_title($post->ID);
        $permalink = home_url('/bancos/' . sanitize_title($titulo) . '/');
    }

    return $permalink;
}
add_filter('post_type_link', 'stcode_custom_post_permalink', 10, 3);

/**
* Cria a regra de rescrita do permalink dos customtype & paginas proprias
*
* @since    0.0.1
*/
add_action('init', 'stcode_add_rewrite_rule');
function stcode_add_rewrite_rule(){
    // Seguimentos
    add_rewrite_rule('^cartoes/([^/]*)/([^/]*)?','index.php?post_type=stcode_seguimentos&cartao_escolhido=$matches[1]&title=$matches[2]','top');
    add_rewrite_rule('^emprestimos/([^/]*)/([^/]*)?','index.php?post_type=stcode_seguimentos&emprestimo_escolhido=$matches[1]&title=$matches[2]','top');
    add_rewrite_rule('^bancos/([^/]*)/([^/]*)?','index.php?post_type=stcode_seguimentos&digital_escolhido=$matches[1]&title=$matches[2]','top');
    // Custom Posts
    add_rewrite_rule('^cartoes/([^/]*)?','index.php?post_type=stcode_cartao&cartao_escolhido=$matches[1]','top');
    add_rewrite_rule('^emprestimos/([^/]*)?','index.php?post_type=stcode_emprestimo&emprestimo_escolhido=$matches[1]','top');
    add_rewrite_rule('^bancos/([^/]*)?','index.php?post_type=stcode_conta_digital&digital_escolhido=$matches[1]','top');

    add_rewrite_rule('melhores-cartoes-de-credito?$','index.php?lista_cartoes=true','top');
}

/**
* Retorna as query criada no rewrite_rule
*
* @since    0.0.1
*/
add_action('query_vars','stcode_set_query_var');
function stcode_set_query_var($vars) {
    array_push($vars, 'cartao_escolhido');
    array_push($vars, 'emprestimo_escolhido');
    array_push($vars, 'digital_escolhido');
    array_push($vars, 'title');
    array_push($vars, 'lista_cartoes');
    array_push($vars, 'quiz_slug');
    return $vars;
}

/**
 * Inclui um template personalizado com base na URL atual.
 *
 * Esta função verifica se a URL atual corresponde a um padrão específico, 
 * onde se espera "cartoes/[algum texto]/[algum texto]". 
 * Se corresponder, um template personalizado é incluído.
 *
 * @since 0.0.1
 * @param string $template O template atual a ser incluído.
 * @return string O template a ser incluído.
 */
add_filter('template_include', 'stcode_include_template', 100, 1);
function stcode_include_template($template){
    global $wp;
    $current_url = add_query_arg(array(), $wp->request);

    // Resolve a ficha pública com ou sem barra final.
    if (preg_match('~^cartoes/([^/]+)/?$~', $wp->request, $card_route)) {
        $id = stcode_get_posts_permalink('cartoes/' . $card_route[1]);
        $card = $id ? get_post($id) : get_page_by_path($card_route[1], OBJECT, 'stcode_cartao');
        if (!$card || $card->post_type !== 'stcode_cartao' || $card->post_status !== 'publish') {
            status_header(404);
            return get_404_template();
        }
        global $wp_query, $post;
        $wp_query = new WP_Query(['post_type' => 'stcode_cartao', 'p' => $card->ID, 'post_status' => 'publish']);
        $post = $card;
        setup_postdata($post);
        $GLOBALS['postID'] = $card->ID;
        status_header(200);
        return STCODE_DIR . '/inc/parts/singles/cartao.php';
    }

    // Verifica se a URL corresponde ao padrão desejado
    if (preg_match('/cartoes\/([^\/]*)\/([^\/]*)/', $current_url, $matches)) {
        $cartao = get_query_var('cartao_escolhido');
        $title = get_query_var('title');
        $post_id_encontrado = stcode_get_post_blog('stcode_cartao', $cartao,$title,'cartao-de-credito','stcode_cartao_escolhido');

        if ($post_id_encontrado) {
            header("HTTP/1.1 200 OK");
            $GLOBALS['postID'] = $post_id_encontrado;
            get_template_part('inc/parts/singles/seguimento');
        } else {
            get_template_part('404');
        }
        exit;
    }

    if (preg_match('/emprestimos\/([^\/]*)\/([^\/]*)/', $current_url, $matches)) {
        $emprestimo = get_query_var('emprestimo_escolhido');
        $title = get_query_var('title');
        $post_id_encontrado = stcode_get_post_blog('stcode_emprestimo', $emprestimo, $title, 'emprestimo', 'stcode_emprestimo_escolhido');
        if ($post_id_encontrado) {
            header("HTTP/1.1 200 OK");
            $GLOBALS['postID'] = $post_id_encontrado;
            get_template_part('inc/parts/singles/seguimento');
        } else {
            get_template_part('404');
        }
        exit;
    }

    if (preg_match('/bancos\/([^\/]*)\/([^\/]*)/', $current_url, $matches)) {
        $digital = get_query_var('digital_escolhido');
        $title = get_query_var('title');
        $post_id_encontrado = stcode_get_post_blog('stcode_conta_digital', $digital, $title, 'conta-digital', 'stcode_conta_digital_escolhido');

        if ($post_id_encontrado) {
            header("HTTP/1.1 200 OK");
            $GLOBALS['postID'] = $post_id_encontrado;
            get_template_part('inc/parts/singles/seguimento');
        } else {
            get_template_part('404');
        }
        exit;
    }

    //
    if (preg_match('/cartoes\/([^\/]+)?$/', $current_url, $matches)) {
        $permalink = 'cartoes/'.get_query_var('cartao_escolhido');
        $post_id_encontrado = stcode_get_posts_permalink($permalink);

        if ($post_id_encontrado) {
            header("HTTP/1.1 200 OK");
            $GLOBALS['postID'] = $post_id_encontrado;
            get_template_part('inc/parts/singles/cartao');
        } else {
            get_template_part('404');
        }
        exit;
    }

    if (preg_match('/emprestimos\/([^\/]+)?$/', $current_url, $matches)) {
        $permalink = 'emprestimos/'.get_query_var('emprestimo_escolhido');
        $post_id_encontrado = stcode_get_posts_permalink($permalink);

        if ($post_id_encontrado) {
            header("HTTP/1.1 200 OK");
            $GLOBALS['postID'] = $post_id_encontrado;
            get_template_part('inc/parts/singles/emprestimo');
        } else {
            get_template_part('404');
        }
        exit;
    }

    if (preg_match('/bancos\/([^\/]+)?$/', $current_url, $matches)) {
        $permalink = 'bancos/'.get_query_var('digital_escolhido');
        $post_id_encontrado = stcode_get_posts_permalink($permalink);

        if ($post_id_encontrado) {
            header("HTTP/1.1 200 OK");
            $GLOBALS['postID'] = $post_id_encontrado;
            get_template_part('inc/parts/singles/banco');
        } else {
            get_template_part('404');
        }
        exit;
    }

    // Catálogo e comparação de cartões.
    $comparison_route = trim($current_url, '/');
    if (in_array($comparison_route, ['comparador-de-cartao-de-credito', 'comparador-de-cartao-de-credito/comparar'], true)) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        $is_catalog = $comparison_route === 'comparador-de-cartao-de-credito';
        add_filter('pre_get_document_title', static function () use ($is_catalog) {
            $title = $is_catalog ? 'Catálogo de cartões de crédito' : 'Comparar cartões de crédito';
            return $title . ' – ' . get_bloginfo('name');
        });
        get_template_part($is_catalog ? 'inc/parts/lista-de-cartoes' : 'inc/parts/comparar');
        exit;
    }

    // Quiz
    if (preg_match('/monify-quiz-([^\/]*)\/index\.html/', $current_url, $matches)) {
        $quiz_slug = $matches[1];
        $quiz_encontrado = stcode_quiz_exist($quiz_slug);

        if ($quiz_encontrado) {
            header("HTTP/1.1 200 OK");
            include_once(STCODE_DIR.'/inc/parts/quiz.php');
        } else {
            get_template_part('404');
        }
        exit;
    }

    // Blog artigos
    if (trim($wp->request, '/') === 'blog') {
        global $wp_query;
        $wp_query->is_404 = false;
        $wp_query->is_home = false;
        status_header(200);
        add_filter('pre_get_document_title', static function () {
            return 'Blog – ' . get_bloginfo('name');
        });
        return STCODE_DIR . '/inc/parts/blog.php';
    }

    return $template;
}

/**
 * Verifica se a URL atual corresponde a padrões específicos relacionados a páginas do site.
 *
 * Esta função verifica se a URL atual corresponde a alguns padrões específicos
 * correspondência for encontrada, caso contrário, retorna false.
 *
 * @since 0.0.1
 * @return bool True se a URL corresponder a algum dos padrões especificados, false caso contrário.
 */
function is_stcode_quiz_page() {
    global $wp;
    $current_url = add_query_arg(array(), $wp->request);

    // Verifica se a URL corresponde ao padrão desejado
    if (preg_match('/monify-quiz-([^\/]*)\/index\.html/', $current_url)) {
        return true;
    }
    return false;
}

/**
 * Verifica se a URL atual corresponde a padrões específicos relacionados a páginas do site.
 *
 * Esta função verifica se a URL atual corresponde a alguns padrões específicos, incluindo URLs contendo
 * "cartoes/", "emprestimos/", "bancos/" ou se a URL é exatamente "cartoes". Retorna true se a 
 * correspondência for encontrada, caso contrário, retorna false.
 *
 * @since 0.0.1
 * @return bool True se a URL corresponder a algum dos padrões especificados, false caso contrário.
 */
function is_stcode_template() {
    global $wp;
    $current_url = add_query_arg(array(), $wp->request);

    // Verifica se a URL corresponde ao padrão desejado
    if (preg_match('/cartoes\/([^\/]*)\/([^\/]*)/', $current_url) OR preg_match('/cartoes\/([^\/]*)?$/', $current_url, $matches) OR $current_url === 'cartoes' OR preg_match('/emprestimos\/([^\/]*)?$/', $current_url, $matches) OR preg_match('/bancos\/([^\/]*)?$/', $current_url, $matches)) {
        return true;
    }
    return false;
}

/**
 * Verifica se a URL atual corresponde a padrões específicos relacionados a páginas de detalhes individuais do site.
 *
 * Esta função verifica se a URL atual corresponde a padrões específicos, incluindo URLs contendo "cartoes/",
 * "emprestimos/" ou "bancos/", ou se é uma página de detalhes de postagem individual. Retorna true 
 * se a correspondência for encontrada, caso contrário, retorna false.
 *
 * @since 0.0.1
 * @return bool True se a URL corresponder a algum dos padrões especificados, false caso contrário.
 */
function is_stcode_template_single() {
    global $wp;
    $current_url = add_query_arg(array(), $wp->request);

    // Verifica se a URL corresponde ao padrão desejado
    if (preg_match('/cartoes\/([^\/]*)\/([^\/]*)/', $current_url) OR preg_match('/emprestimos\/([^\/]*)/', $current_url, $matches) OR preg_match('/bancos\/([^\/]*)/', $current_url, $matches) OR is_singular()) {
        return true;
    }
    return false;
}

/**
 * Verifica se a URL atual corresponde a padrões específicos relacionados a páginas de detalhes individuais do site.
 *
 * Esta função verifica se a URL atual corresponde a padrões específicos, incluindo URLs contendo "cartoes/",
 * "emprestimos/" ou "bancos/", ou se é uma página de detalhes de postagem individual. Retorna true 
 * se a correspondência for encontrada, caso contrário, retorna false.
 *
 * @since 0.0.1
 * @return bool True se a URL corresponder a algum dos padrões especificados, false caso contrário.
 */
function is_stcode_ceb_single() {
    global $wp;
    $current_url = add_query_arg(array(), $wp->request);

    // Verifica se a URL corresponde ao padrão desejado
    if (preg_match('/cartoes\/([^\/]*)?$/', $current_url) OR preg_match('/emprestimos\/([^\/]*)?$/', $current_url, $matches) OR preg_match('/bancos\/([^\/]*)?$/', $current_url, $matches)) {
        return true;
    }
    return false;
}

function is_stcode_archive_list() {
    global $wp;
    $current_url = add_query_arg(array(), $wp->request);

    // Verifica se a URL corresponde ao padrão desejado
    if (trim($current_url, '/') === 'comparador-de-cartao-de-credito') {
        return true;
    }
    return false;
}

/**
 * Obtém o ID de uma postagem do tipo 'seguimentos' com base em vários parâmetros.
 *
 * Esta função busca e retorna o ID de uma postagem do tipo 'seguimentos' com base em parâmetros como 
 * o ID do postagem relacionado, o permalink, o tipo de artigo e uma chave de meta específica.
 *
 * @since 0.0.1
 * @param int    $post_id     O nome do cartao.
 * @param string $permalink   O permalink da postagem.
 * @param string $artigo_tipo O tipo de postagem [cartao, emprestimo, etc..].
 * @param string $meta_key    A chave de meta específica.
 * @return int|null O ID da postagem 'seguimentos', ou null se não for encontrado.
 */
function stcode_get_post_blog($post, $post_id, $permalink, $artigo_tipo, $meta_key)
{
    global $wpdb;

    $post_id = stcode_get_post_cartao($post_id,$post);

    $query = $wpdb->prepare(
        "SELECT p.ID
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
        INNER JOIN {$wpdb->postmeta} pm_cartoes ON p.ID = pm_cartoes.post_id
        INNER JOIN {$wpdb->postmeta} pm_title ON p.ID = pm_title.post_id
        WHERE p.post_type = 'stcode_seguimentos'
        AND p.post_status = 'publish'
        AND pm.meta_key = 'stcode_artigo_tipo'
        AND pm.meta_value = %s
        AND pm_cartoes.meta_key = %s
        AND pm_cartoes.meta_value = %s
        AND pm_title.meta_key = 'stcode_permalink' 
        AND pm_title.meta_value = %s",
        $artigo_tipo,
        $meta_key,
        $post_id,
        $permalink
    );

    $post_id = $wpdb->get_var($query);

    return $post_id;
}

/**
 * Obtém o ID de uma postagem do tipo 'seguimentos' com base em vários parâmetros.
 *
 * Esta função busca e retorna o ID de uma postagem do tipo 'seguimentos' com base em parâmetros como 
 * o ID do postagem relacionado, o permalink, o tipo de artigo e uma chave de meta específica.
 *
 * @since 0.0.1
 * @param int    $post_id     O nome do cartao.
 * @param string $permalink   O permalink da postagem.
 * @param string $artigo_tipo O tipo de postagem [cartao, emprestimo, etc..].
 * @param string $meta_key    A chave de meta específica.
 * @return int|null O ID da postagem 'seguimentos', ou null se não for encontrado.
 */
function stcode_quiz_exist($permalink)
{
    global $wpdb;

    $query = $wpdb->prepare(
        "SELECT p.ID
        FROM {$wpdb->posts} p
        WHERE p.post_name = %s
        AND p.post_status = 'publish' AND p.post_type = 'stcode_questionarios'",
        $permalink
    );

    $post_id = $wpdb->get_var($query);

    return $post_id;
}

/**
 * Obtém o ID de uma postagem com base no cartão e no tipo de postagem.
 *
 * Esta função busca e retorna o ID de uma postagem com base em um cartão específico e no tipo de postagem.
 *
 * @since 0.0.1
 * @param string $cartao     O cartão relacionado à postagem.
 * @param string $post_type  O tipo de postagem.
 * @return int|null O ID da postagem, ou null se não for encontrado.
 */
function stcode_get_posts_permalink($permalink)
{
    global $wpdb;
    $prefix = $wpdb->prefix."stcode_";
    $query = $wpdb->prepare(
        "SELECT post_id
        FROM {$prefix}posts_permalink
        WHERE permalink = %s",
        $permalink
    );

    $post_id = $wpdb->get_var($query);

    return $post_id;
}

/**
 * Obtém o ID de uma postagem com base no título e no tipo de artigo.
 *
 * Esta função busca e retorna o ID de uma postagem do tipo 'post' com base no título e no tipo de artigo.
 *
 * @since 0.0.1
 * @param string $titulo      O título da postagem.
 * @param string $artigo_tipo O tipo de artigo.
 * @return int|null O ID da postagem, ou null se não for encontrado.
 */
function stcode_get_post_cartao($titulo, $artigo_tipo)
{
    global $wpdb;

    $query = $wpdb->prepare(
        "SELECT p.ID
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
        WHERE p.post_type = 'post'
        AND p.post_status = 'publish'
        AND t.name = %s
        AND p.post_title = %s
        AND pm.meta_key = 'stcode_artigo_tipo'
        AND pm.meta_value = %s",
        $titulo,
        $artigo_tipo
    );

    $post_id = $wpdb->get_var($query);

    return $post_id;
}

/**
 * Obtém informações da primeira tag associada a uma postagem.
 *
 * Esta função busca e retorna informações da primeira tag associada a uma postagem, incluindo o link, o ID e o nome da tag.
 *
 * @since 0.0.1
 * @param int    $post_id   O ID da postagem.
 * @param string $attribute O atributo a ser retornado ('name', 'term_id' ou 'slug').
 * @param int    $length    O comprimento máximo da lista de tags a serem recuperadas.
 * @return array Um array contendo o link, o ID e o nome da primeira tag, ou um array vazio se não houver tags associadas à postagem.
 */
function get_tag_post( $post_id, $attribute = '', $length = 0 )
{
    $csv = '';
    $terms = array();

    // Nothing to do for non-attributes 
    if( ! in_array( $attribute, [ 'name', 'term_id', 'slug' ] ) )
        return $csv;

    // Fetch terms
    $terms = get_the_tags( $post_id );

    // Nothing to do if we don't have a non-empty array of terms 
    if( ! is_array( $terms ) || empty( $terms ) ){
        $dados['link']  = '#';
        $dados['id']    = null;
        $dados['name']  = null;
        return $dados;
    }

    // Slice the array if needed
    if( (int) $length > 0 )
        $terms = array_slice( $terms, 0, (int) $length );

    // Pluck the terms array
    //$terms = wp_list_pluck( $terms, $attribute );

    $terms          = $terms[0];
    $dados['link']  = get_tag_link($terms->term_id);
    $dados['id']    = $terms->term_id;
    $dados['name']  = $terms->name;

    return $dados;
    
}
/**
* Função de gerar imagem em formatos responsivos com versão webp
*
* @since    0.0.1
*/
function stcodes_generate_picture($post_id, $class = null, $sizes = null, $webp = true) {
    $attachment_id = get_post_thumbnail_id($post_id);
    $image = $attachment_id ? wp_get_attachment_image($attachment_id, 'large', false, [
        'alt' => get_the_title($post_id),
        'loading' => 'lazy',
    ]) : '';
    if ($image === '') {
        $image = '<img src="' . esc_url(STCODE_URI . '/assets/vetors/credit.svg') . '" alt="' . esc_attr(get_the_title($post_id)) . '" loading="lazy">';
    }
    return '<picture' . ($class ? ' class="' . esc_attr($class) . '"' : '') . '>' . $image . '</picture>';
}

/**
* Muda o formato da imagem
*
* @since    0.0.1
*/
function get_custom_image_srcset($attachment_id, $size = '1000w', $format = 'webp') {
    // Get the image URL using wp_get_attachment_image_src
    $images = wp_get_attachment_image_srcset( $attachment_id, $size );


    // Check if the image format is JPEG
    $path = pathinfo($images, PATHINFO_EXTENSION);
    if (stripos($path, 'jpg') !== false || stripos($path, 'jpeg') !== false) {
        // Replace the file extension with the desired format
        $images = preg_replace('/\.(jpg|jpeg)/', '.' . $format, $images);
    }

    if (stripos($path, 'png') !== false) {
        // Replace the file extension with the desired format
        $images = preg_replace('/\.(png)/', '.' . $format, $images);
    }

    // Return the modified image URL
    return $images;
}

/**
* Muda o formato da imagem
*
* @since    0.0.1
*/
function get_custom_image_src($attachment_id, $size = '1000w', $format = 'webp') {
    // Get the image URL using wp_get_attachment_image_src
    $images = wp_get_attachment_image_src( $attachment_id, $size );


    // Check if the image format is JPEG
    $path = pathinfo($images[0], PATHINFO_EXTENSION);
    if ($path === 'jpg' || $path === 'jpeg') {
        // Replace the file extension with the desired format
        $images = preg_replace('/\.(jpg|jpeg)/', '.' . $format, $images[0]);
    }

    if ($path === 'png') {
        // Replace the file extension with the desired format
        $images = preg_replace('/\.(png)/', '.' . $format, $images[0]);
    }

    // Return the modified image URL
    return $images;
}

function get_solo_image($post_id){
    $attachment_id = get_post_thumbnail_id( $post_id );
    $image_large_src = wp_get_attachment_image_src( $attachment_id, 'medium' );

    return (isset($image_large_src[0]) ? $image_large_src[0] : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP89B8AAukB8/71MdcAAAAASUVORK5CYII=');
}

/**
 * Retorna o nome do tipo de artigo com base no valor fornecido.
 *
 * Esta função recebe um valor como entrada e retorna o nome correspondente do tipo de artigo.
 *
 * @since 0.0.1
 * @param string $value O valor do tipo de artigo.
 * @return string O nome do tipo de artigo correspondente ao valor fornecido.
 */
function stcode_artigoname($value)
{
    switch ($value) {
        case 'cartao-de-credito':
            $val = 'Cartão de Crédito';
        break;

        case 'conta-digital':
            $val = 'Conta Digital';
        break;

        case 'emprestimo':
            $val = 'Empréstimo';
        break;
        
        default:
            $val = 'Indefinido';
        break;
    }

    return $val;
}

/**
 * Custom wrapper
 *
 * ex: echo get_terms_list_attribute( 
    $post_id   = get_the_ID(), 
    $taxonomy  = 'product_cat', 
    $attribute = 'name', 
    $length    = 2 
);
 * @return string Comma seperated term attribute values
 */
function get_terms_list_attribute( $post_id, $taxonomy = '', $attribute = '', $length = 0 )
{
    $csv = '---';
    $terms = array();

    // Nothing to do for non-attributes 
    if( ! in_array( $attribute, [ 'name', 'term_id', 'slug' ] ) )
        return $csv;

    // Nothing to do if taxonomy doesn't exists
    if( ! taxonomy_exists( $taxonomy ) )
        return $csv;

    // Fetch terms
    $terms = get_the_terms( $post_id, $taxonomy );

    // Nothing to do if we don't have a non-empty array of terms 
    if( ! is_array( $terms ) || empty( $terms ) )
        return $csv;

    // Slice the array if needed
    if( (int) $length > 0 )
        $terms = array_slice( $terms, 0, (int) $length );

    // Pluck the terms array
    $terms = wp_list_pluck( $terms, $attribute );

    // Generate a list of comma separated term attribute values 
    $csv = join( ', ', $terms );

    return $csv;
}

/**
 * Verifica se uma pergunta existe com base no ID do post e no título da pergunta.
 *
 * @since 0.0.1
 * @param int $post_id O ID do post.
 * @param string $question_title O título da pergunta.
 * @return bool Retorna verdadeiro se a pergunta existir, caso contrário, falso.
 */
function stcode_question_exists($post_id, $question_title) {
    global $wpdb;

    $prefix = $wpdb->prefix;

    $result = $wpdb->get_var($wpdb->prepare("
        SELECT COUNT(*)
        FROM {$prefix}stcode_questionario
        WHERE post_id = %d AND question_title = %s
    ", $post_id, $question_title));

    return $result > 0;
}

/**
 * Insere uma pergunta e suas respostas no banco de dados.
 *
 * @since 0.0.1
 * @param int $post_id O ID do post.
 * @param string $question_title O título da pergunta.
 * @param array $answers As respostas para a pergunta.
 * @param int $question_type O tipo da pergunta.
 */
function stcode_insert_questions_answer($post_id, $question_title, $answers, $question_type)
{
    // Chama a Global WPDB
    global $wpdb;

    // Guarda o prefixo do WP
    $prefix = $wpdb->prefix;

    $serialized_answers = maybe_serialize($answers);

    $wpdb->insert(
        "{$prefix}stcode_questionario",
        array(
            'post_id' => $post_id,
            'question_title' => $question_title,
            'answer' => $serialized_answers,
            'question_type' => $question_type
        ),
        array(
            '%d', // para post_id (inteiro)
            '%s', // para question_title (string)
            '%s',  // para answer (string)
            '%d', // para question_type (inteiro)
        )
    );
}

/**
 * Atualiza as respostas de uma pergunta no banco de dados.
 *
 * @since 0.0.1
 * @param int $post_id O ID do post.
 * @param string $question_title O título da pergunta.
 * @param array $answers As novas respostas para a pergunta.
 * @param int $question_type O tipo da pergunta.
 */
function stcode_update_questions_answer($post_id, $question_title, $answers, $question_type) {
    global $wpdb;
    $prefix = $wpdb->prefix;

    // Certifique-se de que a resposta esteja serializada corretamente
    $serialized_answers = maybe_serialize($answers);

    $result = $wpdb->update(
        "{$prefix}stcode_questionario",
        array('answer' => $serialized_answers,'question_type' => $question_type), // Garanta que esteja serializado
        array(
            'post_id' => $post_id,
            'question_title' => $question_title
        ),
        array('%s','%d'), // Formato para 'answer'
        array('%d', '%s') // Formatos para 'post_id', 'question_title', 'question_type'
    );

    // Verifique se houve erro na atualização
    if (false === $result) {
        // Há um erro. Você pode querer logar ou tratar esse erro aqui.
        error_log('Erro ao atualizar a resposta: ' . $wpdb->last_error);
    }
}

/**
 * Exclui as respostas de uma pergunta do banco de dados.
 *
 * @since 0.0.1
 * @param int $post_id O ID do post.
 * @param string $question_title O título da pergunta.
 */
function stcode_delete_questions_answer( $post_id, $question_title )
{
    // Chama a Global WPDB
    global $wpdb;

    // Guarda o prefixo do WP
    $prefix = $wpdb->prefix;

    $wpdb->delete(
        "{$prefix}stcode_questionario",
        array(
            'post_id' => $post_id,
            'question_title' => $question_title
        ),
        array(
            '%d', // Formato do dado para 'post_id'
            '%s'  // Formato do dado para 'question_title'
        )
    );

}

/**
 * Exclui uma pergunta do banco de dados com base em seu ID.
 *
 * @since 0.0.1
 * @param int $question_id O ID da pergunta.
 */
function stcode_delete_question_by_id($question_id) {
    global $wpdb;

    $prefix = $wpdb->prefix;

    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$prefix}stcode_questionario WHERE question_id = %d",
            $question_id
        )
    );
}

/**
 * Obtém as respostas de uma pergunta do banco de dados.
 *
 * @since 0.0.1
 * @param int $post_id O ID do post.
 * @param string $question_title O título da pergunta.
 * @return array As respostas da pergunta.
 */
function stcode_get_questions_answer( $post_id, $question_title )
{
    // Chama as Globais WPDB e post
    global $wpdb, $post;

    // Guarda o prefixo do WP
    $prefix = $wpdb->prefix;

    // Pega o link da página do capítulo
    $result = $wpdb->get_results("
        SELECT * FROM {$prefix}stcode_questionario
        WHERE post_id = '{$post_id}' AND question_title = '{$question_title}'
    ", ARRAY_A);

    return ( count($result) >= 1 ) ? $result[0] : '';
}

/**
 * Obtém todas as perguntas relacionadas a um determinado post.
 *
 * @since 0.0.1
 * @param int $id O ID do post.
 * @return array As perguntas relacionadas ao post.
 */
function stcode_get_all_questions($id)
{
    if ($id != '') {
        // Chama a global do WPDB
        global $wpdb;

        // Salva o prefixo do WP
        $prefix = $wpdb->prefix;

        $result = $wpdb->get_results("
            SELECT * FROM {$prefix}stcode_questionario
            WHERE post_id = '{$id}'
        ", ARRAY_A);

        return ( count($result) >= 1 ) ? $result : [];
    } else {
        return [];
    }
}

/**
 * Insere um registro de quiz no banco de dados.
 *
 * @since 0.0.1
 * @param int $questionario_id O ID do questionário.
 * @param string $quiz_tipo O tipo de quiz.
 * @param string $nome O nome do usuário.
 * @param string $email O email do usuário.
 * @param array $respostas As respostas do usuário.
 * @return bool Retorna verdadeiro se a inserção for bem-sucedida, caso contrário, falso.
 */
function inserir_quiz_registro($questionario_id, $quiz_tipo, $nome, $email, $respostas ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'stcode_quiz_registros';

    $result = $wpdb->insert(
        $table_name,
        array(
            'quiz_tipo' => $quiz_tipo,
            'questionario_id' => $questionario_id,
            'nome' => $nome,
            'email' => $email,
            'respostas' => $respostas
        ),
        array(
            '%s',
            '%d',
            '%s',
            '%s',
            '%s'
        )
    );

    if($result === false) {
        return false;
    } else {
        return true;
    }
}

/**
 * Atualiza um registro de quiz no banco de dados.
 *
 * @since 0.0.1
 * @param int $quiz_id O ID do registro de quiz a ser atualizado.
 * @param string $quiz_tipo O tipo de quiz.
 * @param int $questionario_id O ID do questionário.
 * @param string $nome O nome do usuário.
 * @param string $email O email do usuário.
 * @param array $respostas As respostas do usuário.
 * @return bool Retorna verdadeiro se a atualização for bem-sucedida, caso contrário, falso.
 */
function atualizar_quiz_registro($quiz_id, $quiz_tipo, $questionario_id, $nome, $email, $respostas) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'stcode_quiz_registros';

    $result = $wpdb->update(
        $table_name,
        array(
            'questionario_id' => $questionario_id,
            'nome' => $nome,
            'email' => $email,
            'quiz_tipo' => $quiz_tipo,
            'respostas' => $respostas
        ),
        array('quiz_id' => $quiz_id),
        array(
            '%d',
            '%s',
            '%s',
            '%s'
        ),
        array('%d')
    );

    if($result === false) {
        return false;
    } else {
        return true;
    }
}

/**
 * Exclui um registro de quiz do banco de dados.
 *
 * @since 0.0.1
 * @param int $quiz_id O ID do registro de quiz a ser excluído.
 */
function excluir_quiz_registro($quiz_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'stcode_quiz_registros';

    $result = $wpdb->delete(
        $table_name,
        array('quiz_id' => $quiz_id),
        array('%d')
    );

    if($result === false) {
        die('Houve um erro ao excluir o registro!');
    }
}

/**
 * Verifica se um registro de quiz já existe no banco de dados com base no nome, email e ID do questionário.
 *
 * @since 0.0.1
 * @param string $nome O nome do usuário.
 * @param string $email O email do usuário.
 * @param int $questionario_id O ID do questionário.
 * @return object|bool Retorna o registro de quiz se existir, caso contrário, falso.
 */
function quiz_registro_existe($nome,$email,$questionario_id)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'stcode_quiz_registros';

    $existing_record = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE nome = %s AND email = %s AND questionario_id = %d", $nome, $email, $questionario_id));

    return $existing_record;
}

/**
 * Função principal para processar o envio do registro do quiz.
 *
 * @since 0.0.1
 */
function call_quiz_registro() {
    $id = isset($_POST['id']) && is_scalar($_POST['id']) ? absint($_POST['id']) : 0;
    $quiz = $id ? get_post($id) : null;
    if (!post_type_exists('stcode_questionarios') || !$quiz || $quiz->post_type !== 'stcode_questionarios' || $quiz->post_status !== 'publish') {
        wp_send_json_error(['message' => 'Questionário indisponível.'], 400);
    }
    check_ajax_referer('monify-quiz-' . $id, 'nonce');
    $name = isset($_POST['name']) && is_string($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $email = isset($_POST['email']) && is_string($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $raw = isset($_POST['quiz']) && is_string($_POST['quiz']) ? wp_unslash($_POST['quiz']) : '';
    if (!$name || strlen($name) > 255 || !is_email($email) || strlen($email) > 254 || strlen($raw) > 16384) {
        wp_send_json_error(['message' => 'Confira os dados enviados.'], 400);
    }
    $answers = json_decode($raw, true);
    $questions = stcode_get_all_questions($id);
    if (!is_array($answers) || count($answers) !== count($questions) || !$questions) {
        wp_send_json_error(['message' => 'Respostas inválidas.'], 400);
    }
    foreach (array_values($questions) as $index => $question) {
        $answer = $answers[$index] ?? null;
        $choices = unserialize($question['answer'], ['allowed_classes' => false]);
        if (!is_array($answer) || ($answer['title'] ?? null) !== $question['question_title']
            || !is_array($choices) || !in_array($answer['answer'] ?? null, $choices, true)) {
            wp_send_json_error(['message' => 'Resposta inválida.'], 400);
        }
    }
    $rate_key = 'monify_quiz_' . hash('sha256', $id . '|' . strtolower($email));
    if (get_transient($rate_key)) {
        wp_send_json_error(['message' => 'Aguarde antes de enviar novamente.'], 429);
    }
    $existing = quiz_registro_existe($name, $email, $id);
    $data = maybe_serialize($answers);
    $saved = $existing
        ? atualizar_quiz_registro($existing->quiz_id, $quiz->post_title, $id, $name, $email, $data)
        : inserir_quiz_registro($id, $quiz->post_title, $name, $email, $data);
    if (!$saved) {
        wp_send_json_error(['message' => 'Não foi possível salvar.'], 500);
    }
    set_transient($rate_key, 1, MINUTE_IN_SECONDS);
    wp_send_json(['success' => true]);
}

add_action( 'wp_ajax_nopriv_send_cliente_quiz', 'call_quiz_registro' );
add_action( 'wp_ajax_send_cliente_quiz', 'call_quiz_registro' );

/**
 * Verifica se um registro de quiz já existe no banco de dados com base no nome, email e ID do questionário.
 *
 * @since 0.0.1
 * @param string $nome O nome do usuário.
 * @param string $email O email do usuário.
 * @param int $questionario_id O ID do questionário.
 * @return object|bool Retorna o registro de quiz se existir, caso contrário, falso.
 */
function check_permalink_exists($permalink) {
    global $wpdb;

    $prefix = $wpdb->prefix."stcode_";

    $table_name = $prefix . 'posts_permalink';

    // Consulta para verificar se o permalink já existe na tabela
    $query = $wpdb->prepare(
        "SELECT COUNT(*) FROM {$table_name} WHERE permalink = %s",
        $permalink
    );

    // Executar a consulta
    $exists = $wpdb->get_var($query);

    return $exists ? true : false;
}

/**
 * Insere um novo registro na tabela posts_permalink.
 *
 * @since 1.0.0
 * @param int $post_id O ID do post.
 * @param string $permalink O permalink do post.
 * @param string $last_update A data e hora da última atualização do registro.
 * @return int|false Retorna o ID do registro inserido se bem-sucedido, caso contrário, retorna false.
 */
function insert_into_posts_permalink($post_id, $permalink, $last_update) {
    global $wpdb;

    $prefix = $wpdb->prefix."stcode_";

    $table_name = $prefix . 'posts_permalink';

    // Preparar os dados para inserção
    $data = array(
        'post_id' => $post_id,
        'permalink' => $permalink,
        'last_update' => $last_update
    );

    // Formato dos dados
    $data_format = array(
        '%d',
        '%s',
        '%s'
    );

    // Inserir os dados na tabela
    $wpdb->insert($table_name, $data, $data_format);

    // Verificar se houve erro na inserção
    if ($wpdb->last_error !== '') {
        return false; // Retorna false se houve erro
    }

    // Retorna o ID do último registro inserido, se necessário
    return $wpdb->insert_id;
}

/**
 * Insere um novo registro na tabela posts_permalink ou atualiza um registro existente.
 *
 * @since 1.0.0
 * @param int $post_id O ID do post.
 * @param string $permalink O permalink do post.
 * @param string $last_update A data e hora da última atualização do registro.
 * @return bool Retorna true se a operação foi bem-sucedida, caso contrário, retorna false.
 */
function insert_or_update_posts_permalink($post_id, $permalink, $last_update) {
    global $wpdb;

    $prefix = $wpdb->prefix."stcode_";

    // Verificar se o permalink já existe na tabela
    $exists = check_permalink_exists($permalink);

    if ($exists) {
        // Se o permalink já existe, atualizar os dados
        $table_name = $prefix . 'posts_permalink';

        // Preparar os dados para atualização
        $data = array(
            'post_id' => $post_id,
            'last_update' => $last_update
        );

        // Formato dos dados
        $where = array(
            'permalink' => $permalink
        );

        // Atualizar os dados na tabela
        $wpdb->update($table_name, $data, $where);

        // Verificar se houve erro na atualização
        if ($wpdb->last_error !== '') {
            return false; // Retorna false se houve erro
        }

        return true; // Retorna true se a atualização foi bem-sucedida
    } else {
        // Se o permalink não existir, inserir um novo registro
        return insert_into_posts_permalink($post_id, $permalink, $last_update);
    }
}

/**
 * Função para fazer carregamento sem paginaçao com ajax
 * @link https://rudrastyh.com/wordpress/load-more-posts-ajax.html 
 * @since 0.0.1
 */
add_action( 'wp_ajax_loadmore', 'loadmore_ajax_handler' ); // wp_ajax_{action}
add_action( 'wp_ajax_nopriv_loadmore', 'loadmore_ajax_handler' ); // wp_ajax_nopriv_{action}

function loadmore_ajax_handler() {
    $raw = isset($_POST['query']) && is_string($_POST['query']) ? wp_unslash($_POST['query']) : '{}';
    $filters = strlen($raw) <= 4096 ? json_decode($raw, true) : [];
    $filters = is_array($filters) ? $filters : [];
    $page = isset($_POST['page']) && is_scalar($_POST['page']) ? absint($_POST['page']) : 1;
    $args = [
        'post_type' => 'post', 'post_status' => 'publish',
        'posts_per_page' => 25, 'paged' => max(1, min(1000, $page + 1)),
    ];
    foreach (['cat', 'author'] as $key) {
        if (isset($filters[$key]) && is_scalar($filters[$key])) {
            $args[$key] = absint($filters[$key]);
        }
    }
    $posts = new WP_Query($args);
    while ($posts->have_posts()) {
        $posts->the_post();
        get_template_part('inc/parts/article');
    }
    wp_reset_postdata();
    wp_die();
}

/**
 * Função para fazer carregamento sem paginaçao com ajax [blog]
 * @since 0.0.1
 */
function blog_loadmore_ajax_handler() {
    $page = isset($_POST['paged']) && is_scalar($_POST['paged']) ? max(1, min(1000, absint($_POST['paged']))) : 1;
    $posts = new WP_Query([
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 25,
        'orderby' => ['date' => 'DESC', 'ID' => 'DESC'],
        'paged' => $page,
    ]);
    ob_start();
    while ($posts->have_posts()) {
        $posts->the_post();
        get_template_part('inc/parts/article');
    }
    $html = ob_get_clean();
    wp_reset_postdata();
    wp_send_json(['max_page' => $posts->max_num_pages, 'html' => $html]);
}

add_action('wp_ajax_blog_load_more', 'blog_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_blog_load_more', 'blog_loadmore_ajax_handler');

function generate_accordion_section($section) {
    $lines = explode("\n", $section);
    $html = '';
    $tab_title = '';

    foreach ($lines as $line) {
        $line = trim($line);

        if (!empty($line)) {
            if (strpos($line, '¿') !== false) {
                $tab_title = trim(str_replace('¿', '', $line));
            } elseif (strpos($line, '|') !== false) {
                $items = explode('|', $line);
                $list_items = '';
                foreach ($items as $item) {
                    $list_items .= '                                <li>' . trim($item) . '</li>' . "\n";
                }
                $html .= '                <ul>' . "\n" . $list_items . '                </ul>' . "\n";
            } else {
                $html .= '                <p>' . $line . '</p>' . "\n";
            }
        }
    }

    if (!empty($tab_title)) {
        $id = wp_unique_id('monify-tab-');
        $html = '
            <li class="accordion-item">
                <a href="javascript:void(0);" class="accordion-title" aria-controls="'.$id.'-accordion" role="tab" id="'.$id.'-accordion-label" aria-expanded="false" aria-selected="false">' . $tab_title . ' <i class="bx bx-chevron-down"></i></a>
                <div class="accordion-content" role="tabpanel" aria-labelledby="'.$id.'-accordion-label" aria-hidden="true" id="'.$id.'-accordion" style="display: none;">
                    <div itemprop="text">
' . $html . '
                    </div>
                </div>
            </li>';
    }
    return $html;
}

function generate_accordion_html($text) {
    $sections = explode("--", $text);
    $html = '';
    
    foreach ($sections as $section) {
        $html .= generate_accordion_section(trim($section));
    }
    
    return $html;
}
