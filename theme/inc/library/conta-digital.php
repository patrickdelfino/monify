<?php
/**
 * Conta Dígital [ Registro de contas digitais ]
 *
 * @author Sarthemes <sarthemes@gmail.com>
 * @link https://sarthemes.com/
 * @copyright 2020-2024 Sarthemes
 */

use STCode\MetafieldsPosts;

class ContaDigital {

    private static $instance;
    private function __construct() {
        add_action('init', [$this,'registrar_post_type']);
        add_action('add_meta_boxes', [$this,'adicionar_campos_customizados']);
        add_action('save_post', [$this,'salvar_campos_customizados']);
    }

    public static function get_instance() 
    {
        if ( null == self::$instance ) {
            self::$instance = new ContaDigital();
        }
        return self::$instance;
    }

    public function registrar_post_type() {
        $labels = array(
            'name'               => 'Contas Dígitais',
            'singular_name'      => 'Conta Dígital',
            'menu_name'          => 'Contas Dígitais',
            'add_new'            => 'Adicionar',
            'add_new_item'       => 'Adicionar Conta Dígital',
            'edit_item'          => 'Editar Conta Dígital',
            'new_item'           => 'Nova Conta Dígital',
            'view_item'          => 'Ver Conta Dígital',
            'search_items'       => 'Buscar Contas Dígitais',
            'not_found'          => 'Nenhuma conta digital encontrada',
            'not_found_in_trash' => 'Nenhuma conta digital encontrada na lixeira',
        );

        $args = array(
            'labels'             => $labels,
            'labels'              => $labels,
            'supports'            => array('editor','title','thumbnail'),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 4,
            'menu_icon'           => 'dashicons-stcode-digital',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => false,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'capability_type'     => 'post',
            'publicly_queryable'  => true,
            'taxonomies'         => array('pros', 'contras', 'perfil_ideal', 'documentos'), // Taxonomias para Prós e Contras
        );

        register_post_type('stcode_conta_digital', $args);
    }

    // Adicionar campos customizados
    public function adicionar_campos_customizados() {
        add_meta_box('campos_conta_digital','Detalhes',[$this,'mostrar_campos_customizados'],'stcode_conta_digital','normal','default');

    }

    public function mostrar_campos_customizados($post) {
        // Nonce security
        wp_nonce_field('_conta_digital_nonce', 'conta_digital_nonce');
        $opcs = array(
            array(
                'id'     => 'titulo_original',
                'type'   => 'text',
                'label'  => 'Nome do Banco:',
            ),
            array(
                'id'     => 'stcode_banco_link',
                'type'   => 'text',
                'label'  => 'Link:',
            ),
            array(
                'id'     => 'stcode_tarifa_conta',
                'type'   => 'text',
                'label'  => 'Tarifas da conta:',
            ),
            array(
                'id'     => 'stcode_tarifa_saque',
                'type'   => 'text',
                'label'  => 'Tarifas de saque:',
            ),
            array(
                'id'        => 'stcode_rendimento',
                'type'      => 'text',
                'label'     => 'Rendimento da conta:',
            ),
            array(
                'id'        => 'stcode_beneficios',
                'type'      => 'textarea',
                'label'     => 'Produtos disponíveis:',
            ),
            array(
                'id'        => 'stcode_notas',
                'type'      => 'select',
                'label'     => 'Monify Avaliação:',
                'clabel'    => 'Qual nota para o cartão?',
                'options'   => [
                    '1' => '1+',
                    '1.1' => '1.1+',
                    '1.2' => '1.2+',
                    '1.3' => '1.3+',
                    '1.4' => '1.4+',
                    '1.5' => '1.5+',
                    '2' => '2+',
                    '2.1' => '2.1+',
                    '2.2' => '2.2+',
                    '2.3' => '2.3+',
                    '2.4' => '2.4+',
                    '2.5' => '2.5+',
                    '3' => '3+',
                    '3.1' => '3.1+',
                    '3.2' => '3.2+',
                    '3.3' => '3.3+',
                    '3.4' => '3.4+',
                    '3.5' => '3.5+',
                    '4' => '4+',
                    '4.1' => '4.1+',
                    '4.2' => '4.2+',
                    '4.3' => '4.3+',
                    '4.4' => '4.4+',
                    '4.5' => '4.5+',
                    '5' => '5+'
                ]
            ),
        );

        new MetafieldsPosts($opcs);
    }

    public function salvar_campos_customizados($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
        if (!isset( $_POST['conta_digital_nonce'] ) || ! wp_verify_nonce( $_POST['conta_digital_nonce'], '_conta_digital_nonce') ) return;
        if (!current_user_can('edit_post', $post_id ) ) return;

        // Array Post-meta
        $update_post_meta = array(
            'titulo_original','stcode_tarifa_conta','stcode_tarifa_saque','stcode_rendimento','stcode_beneficios','stcode_notas','stcode_banco_link'
        );

        // Generate POST @since 2.1.3
        foreach ($update_post_meta as $i => $key) {
            if ( isset( $_POST[$key] ) ) update_post_meta( $post_id, $key, esc_attr( $_POST[$key] ) ); else delete_post_meta( $post_id, $key );
        }

        $titulo = get_post_meta($post_id, 'titulo_original', true) !== '' ? get_post_meta($post_id, 'titulo_original', true) : get_the_title($post_id);
        $permalink = 'bancos/' . sanitize_title($titulo);

        // Atualizar ou adicionar Permalink no banco
        insert_or_update_posts_permalink($post_id, $permalink, date('c',time()));
    }
}

ContaDigital::get_instance();