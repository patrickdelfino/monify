<?php
/**
 * Seguimento [ Registro ]
 *
 * @author Sarthemes <sarthemes@gmail.com>
 * @link https://sarthemes.com/
 * @copyright 2020-2024 Sarthemes
 */

use STCode\MetafieldsPosts;

class Seguimento {

    private static $instance;
    private function __construct() {
        add_action('init', [$this,'registrar_post_type']);
        add_action('add_meta_boxes', [$this,'adicionar_campos_customizados']);
        add_action('save_post', [$this,'salvar_campos_customizados']);
        add_action('save_post', [$this,'custom_post_name_on_publish']);
        add_action('admin_footer', [$this,'ocultar_perma_link_gutenberg']);
        add_filter('manage_stcode_seguimentos_posts_columns', [$this, 'adicionar_colunas_personalizadas']);
        add_action('manage_stcode_seguimentos_posts_custom_column', [$this, 'exibir_conteudo_colunas_personalizadas'], 10, 2);
    }

    public static function get_instance() 
    {
        if ( null == self::$instance ) {
            self::$instance = new Seguimento();
        }
        return self::$instance;
    }

    public function ocultar_perma_link_gutenberg() {
        global $post;

        if ($post && $post->post_type === 'stcode_seguimentos') {
            ?>
            <style type="text/css">
                .edit-post-post-url {
                    display: none;
                }
            </style>
            <?php
        }
    }

    public function registrar_post_type() {
        $labels = array(
            'name'               => 'Seguimento',
            'singular_name'      => 'Seguimento',
            'menu_name'          => 'Seguimentos',
            'add_new'            => 'Adicionar',
            'add_new_item'       => 'Adicionar Seguimento',
            'edit_item'          => 'Editar Seguimento',
            'new_item'           => 'Novo Seguimento',
            'view_item'          => 'Ver Seguimento',
            'search_items'       => 'Buscar Seguimentos',
            'not_found'          => 'Nenhum seguimento encontrado',
            'not_found_in_trash' => 'Nenhum seguimento encontrado na lixeira',
        );

        $args = array(
            'labels'             => $labels,
            'labels'              => $labels,
            'supports'            => array('title','editor','thumbnail'),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_rest'        => true,
            'show_in_menu'        => true,
            'menu_position'       => 4,
            'menu_icon'           => 'dashicons-stcode-seguimento',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => false,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'capability_type'     => 'post',
            'publicly_queryable'  => true,
            'taxonomies'         => array('pros', 'contras', 'perfil_ideal'), // Taxonomias para Prós e Contras
        );

        register_post_type('stcode_seguimentos', $args);
    }

    // Adicionar colunas personalizadas na tabela de listagem de posts
    public function adicionar_colunas_personalizadas($columns) {
        $columns['nicho'] = 'Nicho';
        $columns['seguimento'] = 'Seguimento';
        return $columns;
    }

    // Exibir conteúdo das colunas personalizadas
    public function exibir_conteudo_colunas_personalizadas($column, $post_id) {
        switch ($column) {
            case 'nicho':
                $cart_id = (get_post_meta($post_id, 'stcode_cartao_escolhido', true) != '' ? get_post_meta($post_id, 'stcode_cartao_escolhido', true) : (get_post_meta($post_id, 'stcode_emprestimo_escolhido', true) != '' ? get_post_meta($post_id, 'stcode_emprestimo_escolhido', true) : get_post_meta($post_id, 'stcode_conta_digital_escolhido', true)));
                echo '<div class="seg-button">'.get_the_title($cart_id).'</div>';
                break;
            case 'seguimento':
                echo '<div class="seg-cbutton">'.get_post_meta($post_id, 'stcode_permalink', true).'</div>';
                break;
        }
    }

    // Adicionar campos customizados
    public function adicionar_campos_customizados() {
        add_meta_box('campos_artigo','Tipo de artigo:',[$this,'mostrar_campos_customizados'],'stcode_seguimentos','side','default');
        add_meta_box('campos_cartao','Cartão de Crédito:',[$this,'mostrar_cartao'],'stcode_seguimentos','side','default');
        add_meta_box('campos_emprestimo','Empréstimo:',[$this,'mostrar_emprestimo'],'stcode_seguimentos','side','default');
        add_meta_box('campos_banco','Banco:',[$this,'mostrar_banco'],'stcode_seguimentos','side','default');

    }

    public function mostrar_campos_customizados($post) {
        // Nonce security
        wp_nonce_field('_seguimento_nonce', 'seguimento_nonce');
        $opcs = array(
            array(
                'id'        => 'stcode_artigo_tipo',
                'type'      => 'radio',
                'require'   => 'yes',
                'label'     => null,
                'clabel'    => 'Qual o tipo de artigo encaixa aqui.',
                'options'   => [
                    'cartao-de-credito' => 'Cartão de Crédito',
                    'emprestimo' => 'Empréstimo',
                    'conta-digital' => 'Conta Digital'
                ]
            ),
            array(
                'id'            => 'stcode_permalink',
                'type'          => 'text',
                'label'         => 'Permalink do seguimento',
                'placeholder'   => sanitize_title(get_the_title()),
            ),
        );

        new MetafieldsPosts($opcs);
    }

    public function mostrar_cartao($post) {
        $opcs = array(
            array(
                'id'        => 'stcode_cartao_escolhido',
                'type'      => 'post',
                'tipo'      => 'stcode_cartao',
                'label'     => 'Selecionar',
            )
        );

        new MetafieldsPosts($opcs);
    }

    public function mostrar_emprestimo($post) {
        $opcs = array(
            array(
                'id'        => 'stcode_emprestimo_escolhido',
                'type'      => 'post',
                'tipo'      => 'stcode_emprestimo',
                'label'     => 'Selecionar',
            ),
        );

        new MetafieldsPosts($opcs);
    }

    public function mostrar_banco($post) {
        $opcs = array(
            array(
                'id'        => 'stcode_conta_digital_escolhido',
                'type'      => 'post',
                'tipo'      => 'stcode_conta_digital',
                'label'     => 'Selecionar',
            ),
        );

        new MetafieldsPosts($opcs);
    }

    public function salvar_campos_customizados($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
        if (!isset( $_POST['seguimento_nonce'] ) || ! wp_verify_nonce( $_POST['seguimento_nonce'], '_seguimento_nonce') ) return;
        if (!current_user_can('edit_post', $post_id ) ) return;

        // Array Post-meta
        $update_post_meta = array(
            'stcode_artigo_tipo','stcode_permalink','stcode_cartao_escolhido','stcode_emprestimo_escolhido','stcode_conta_digital_escolhido'
        );

        // Generate POST @since 2.1.3
        foreach ($update_post_meta as $i => $key) {
            if ( isset( $_POST[$key] ) ) update_post_meta( $post_id, $key, esc_attr( $_POST[$key] ) ); else delete_post_meta( $post_id, $key );
        }
    }

    public function custom_post_name_on_publish($post_id) {
        if (!current_user_can('edit_post', $post_id)
            || !isset($_POST['seguimento_nonce']) || !is_string($_POST['seguimento_nonce'])
            || !wp_verify_nonce($_POST['seguimento_nonce'], '_seguimento_nonce')) {
            return;
        }

        // Verificar se é uma revisão ou autosave
        if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
            return;
        }

        // Obter o post pelo ID
        $post = get_post($post_id);

        // Verifica se a meta existe
        if ( isset( $_POST['stcode_permalink'] ) AND $_POST['stcode_permalink'] !== get_post_meta($post_id,'stcode_permalink',true) ) {
            // Verificar se é do tipo 'post'
            if ($post->post_type === 'seguimentos') {
                // Aqui você pode definir a lógica para gerar o post_name com base no post_id
                $data = array(
                    'ID' => $post_id,
                    'post_name' => sanitize_title($_POST['stcode_permalink']), // Define o post_name personalizado
                );

                // Desregistra o hook para evitar loops infinitos
                remove_action('save_post', [$this,'custom_post_name_on_publish']);

                // Atualiza os dados do post para definir o post_name personalizado
                wp_update_post($data);

                // Re-registra o hook após a atualização do post
                add_action('save_post', [$this,'custom_post_name_on_publish']);
            }
        }
    }
}

Seguimento::get_instance();