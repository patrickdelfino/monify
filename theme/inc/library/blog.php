<?php
/**
 * Artigo [ Editar default POST ]
 *
 * @author Sarthemes <sarthemes@gmail.com>
 * @link https://sarthemes.com/
 * @copyright 2020-2024 Sarthemes
 */

use STCode\MetafieldsPosts;

class Artigo {

    private static $instance;
    private function __construct() {
        add_filter('post_type_labels_post', [$this, 'alterar_labels_post_type']);
        add_action('init', [$this, 'remover_comentarios_post_type']);
        add_action('init', [$this,'remover_taxonomia_tags']);
        add_action('add_meta_boxes', [$this,'adicionar_campos_customizados']);
        add_action('save_post', [$this,'salvar_campos_customizados']);
    }

    public static function get_instance() 
    {
        if ( null == self::$instance ) {
            self::$instance = new Artigo();
        }
        return self::$instance;
    }

    public function alterar_labels_post_type($labels) {
        $labels = array(
            'name'               => 'Artigos',
            'singular_name'      => 'Artigos',
            'menu_name'          => 'Artigos',
            'name_admin_bar'     => 'Meus Artigos',
            'add_new'            => 'Adicionar Novo',
            'add_new_item'       => 'Adicionar Novo',
            'new_item'           => 'Adicionar um Artigo',
            'edit_item'          => 'Editar Artigo',
            'view_item'          => 'Ver Artigo',
            'all_items'          => 'Todos os Artigos',
            'search_items'       => 'Buscar Artigos',
            'parent_item_colon'  => 'Artigos Vinculados',
            'not_found'          => 'Nenhum item encontrado',
            'not_found_in_trash' => 'Nenhum item encontrado na lixeira',
        );

        return $labels;
    }

    public function remover_comentarios_post_type() {
        remove_post_type_support('post', 'comments');
    }

    public function remover_taxonomia_tags() {
        unregister_taxonomy_for_object_type('post_tag', 'post');
    }

    // Adicionar campos customizados ao Cartão de Crédito
    function adicionar_campos_customizados() {
        add_meta_box('campos_artigo','Tipo de artigo:',[$this,'mostrar_campos_customizados'],'post','side','default');

    }

    public function mostrar_campos_customizados($post) {
        // Nonce security
        wp_nonce_field('_artigo_nonce', 'artigo_nonce');
        $opcs = array(
            array(
                'id'        => 'stcode_artigo_tipo',
                'type'      => 'radio',
                'label'     => null,
                'clabel'    => 'Qual o tipo de artigo encaixa aqui.',
                'options'   => [
                    'cartao-de-credito' => 'Cartão de Crédito',
                    'emprestimo' => 'Empréstimo',
                    'conta-digital' => 'Conta Digital'
                ]
            ),
        );

        new MetafieldsPosts($opcs);
    }

    function salvar_campos_customizados($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
        if (!isset( $_POST['artigo_nonce'] ) || ! wp_verify_nonce( $_POST['artigo_nonce'], '_artigo_nonce') ) return;
        if (!current_user_can('edit_post', $post_id ) ) return;

        // Array Post-meta
        $update_post_meta = array(
            'stcode_artigo_tipo'
        );

        // Generate POST @since 2.1.3
        foreach ($update_post_meta as $i => $key) {
            if ( isset( $_POST[$key] ) ) update_post_meta( $post_id, $key, esc_attr( $_POST[$key] ) ); else delete_post_meta( $post_id, $key );
        }
    }

}

Artigo::get_instance();