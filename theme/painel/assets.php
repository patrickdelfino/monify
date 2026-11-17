<?php
/**
 *
 * Arquivos para o back do site
 * @link https://sarthemes.com/
 * @since 0.0.1
 * @package monify/paienl/
 *
 */

/* Carrega as folhas de estilos e de javascripts */
function stcodes_admin_assets() {
    wp_enqueue_style( 'monify-icon', STCODE_URI . '/painel/assets/css/icon.css', false, STCODE_VER );
    if( is_admin() AND isset($_GET['page']) AND $_GET['page'] == 'stcodes-options' ) {
        /* Bootstrap */
        wp_enqueue_style( 'bootstrap', '//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css', false, STCODE_VER );
        wp_enqueue_script( 'bootstrap', '//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js', array(), STCODE_VER, true );
        /* Theme Style */
        wp_enqueue_style( 'monify-painel-theme', STCODE_URI . '/painel/assets/css/style.css', false, STCODE_VER );
        wp_enqueue_style('wp-jquery-ui-dialog' );
        /* CodeMirror */
        wp_enqueue_style( 'codemirror', '//cdn.jsdelivr.net/npm/codemirror@5.60.0/lib/codemirror.min.css?ver=5.60.0', false, STCODE_VER );
        wp_enqueue_script( 'codemirror', '//cdn.jsdelivr.net/npm/codemirror@5.60.0/lib/codemirror.min.js?ver=5.60.0', array(), STCODE_VER, true );
        wp_enqueue_script( 'codemirror-loadmode', '//cdn.jsdelivr.net/npm/codemirror@5.60.0/addon/mode/loadmode.min.js?ver=5.60.0', array(), STCODE_VER, true );
        /* BoxIcons */
        wp_enqueue_style( 'monify-boxicons', STCODE_URI . '/assets/fonts/boxicons/css/boxicons.min.css', false, STCODE_VER );
        /* Theme Javascript */
        wp_enqueue_media();
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-form');
        wp_enqueue_script('stcodes_bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', array(), time(), true );
        wp_enqueue_script( 'monify-painel-menu', STCODE_URI . '/painel/assets/js/menu.js', array(), STCODE_VER );
        wp_enqueue_script( 'monify-painel-scrollable', STCODE_URI . '/painel/assets/js/scrollable.js', array(), STCODE_VER );
        wp_enqueue_script( 'monify-js', STCODE_URI . '/painel/assets/js/functions.min.js', array(), STCODE_VER );
        wp_localize_script('monify-painel-menu', 'STCode', array(
            // Importar
            'ajaxurl'       => admin_url('admin-ajax.php', 'relative'),
            'nonce' => wp_create_nonce('monify-admin-options'),
            'ititle'    => __('Enviar Imagem'),
            'iuse'      => __('Use imagem'),
            'save'      => __('Configurações salvas.'),
            'remov'     => __('Removendo..'),
            'saving'    => __('Salvando alterações..'),
            'save'      => __('Salvar alterações'),
            'justnow'   => __('Ainda agora'),
            'loading'   => __('Carregando..'),
            'cleareg'   => __('Limpar registros'),
            'reset_all' => __('Você realmente deseja excluir este registro?, uma vez concluída, essa ação não recuperará os dados novamente.')
        ));
    }
}

add_action('admin_enqueue_scripts', 'stcodes_admin_assets');

// Save Menu option
function stcodes_side_subnav_section() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Acesso negado.'], 403);
    }
    check_ajax_referer('monify-admin-options', 'nonce');
    $ms = isset($_POST['parent']) && is_string($_POST['parent']) ? sanitize_key(wp_unslash($_POST['parent'])) : null;
    $ss = isset($_POST['child']) && is_string($_POST['child']) ? sanitize_key(wp_unslash($_POST['child'])) : null;
    if($ms and $ss) {
        $data = array(
            'msection' => $ms,
            'ssection' => $ss
        );
        update_option( 'menu_framework_secion', $data );
        wp_send_json($data);
    }
    die();
}
add_action('wp_ajax_stcodes-side-subnav-section', 'stcodes_side_subnav_section');


// Upload and save option
add_action('wp_ajax_sarthemes_ajax_upload', 'sarthemes_upload_image');
function sarthemes_upload_image() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Acesso negado.'], 403);
    }
    check_ajax_referer('monify-admin-options', 'nonce');
    $id = isset($_POST['data']) && is_string($_POST['data']) ? sanitize_key(wp_unslash($_POST['data'])) : '';
    $id = str_replace(array('stcodes_options','[',']'), '', $id);
    require STCODE_DIR . '/painel/options.php';
    $allowed = array_column(array_filter($options, static function ($field) {
        return ($field['type'] ?? '') === 'image';
    }), 'id');
    if (!in_array($id, $allowed, true)) {
        wp_send_json_error(['message' => 'Campo inválido.'], 400);
    }

    $url = isset($_POST['url']) && is_string($_POST['url']) ? esc_url_raw(wp_unslash($_POST['url'])) : '';
    if( isset($id) and isset($url) ) {
        stcode_set_option($id, $url);
    }
    die();
}

// Delete options
add_action('wp_ajax_sarthemes_ajax_remove', 'sarthemes_remove_image');
function sarthemes_remove_image() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Acesso negado.'], 403);
    }
    check_ajax_referer('monify-admin-options', 'nonce');
    $id = isset($_POST['data']) && is_string($_POST['data']) ? sanitize_key(wp_unslash($_POST['data'])) : '';
    $id = str_replace(array('stcodes_options','[',']'), '', $id);
    require STCODE_DIR . '/painel/options.php';
    $allowed = array_column(array_filter($options, static function ($field) {
        return ($field['type'] ?? '') === 'image';
    }), 'id');
    if (!in_array($id, $allowed, true)) {
        wp_send_json_error(['message' => 'Campo inválido.'], 400);
    }

    if(isset($id)) {
        stcode_set_option($id, '');
    }
    die();
}