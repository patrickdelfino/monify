<?php
function registrar_menu_pagina_quiz() {
    // Adiciona uma nova página ao menu de administração
    add_submenu_page(
        'edit.php?post_type=stcode_questionarios', // Página pai
        'Registros do Quiz', // Título da página
        'Registros', // Título do menu
        'manage_options', // Capacidade necessária para acessar esta página
        'quiz-registros', // Slug da página
        'renderizar_pagina_registros_quiz' // Função para renderizar a página
    );
}
add_action('admin_menu', 'registrar_menu_pagina_quiz');

function renderizar_pagina_registros_quiz() {
    if (!current_user_can('manage_options')) {
        wp_die('Acesso negado.', '', ['response' => 403]);
    }
    // Verifique se a classe WP_List_Table está disponível
    if (!class_exists('WP_List_Table')) {
        require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
    }

    // Nossa classe personalizada estendida de WP_List_Table
    class Quiz_Registros_List_Table extends WP_List_Table {
        public function prepare_items() {
            global $wpdb;
            $columns = $this->get_columns();
            $hidden = array();
            $sortable = $this->get_sortable_columns();

            // Define a variável $sql e começa a construção da consulta
            $prefix = $wpdb->prefix."stcode_";
            $sql = "SELECT * FROM {$prefix}quiz_registros";

            // Processa os termos de pesquisa
            $search_term = isset($_REQUEST['s']) && is_string($_REQUEST['s']) ? sanitize_text_field(wp_unslash($_REQUEST['s'])) : '';

            // Adiciona condições de pesquisa à consulta SQL
            if (!empty($search_term)) {
                $like = '%' . $wpdb->esc_like($search_term) . '%';
                $sql .= $wpdb->prepare(" WHERE nome LIKE %s OR email LIKE %s", $like, $like);
            }

            $this->_column_headers = array($columns, $hidden, $sortable);

            $per_page = 20;
            $current_page = $this->get_pagenum();
            $total_items = $this->record_count();

            $this->set_pagination_args([
                'total_items' => $total_items, 
                'per_page'    => $per_page 
            ]);

            $this->items = $this->get_records($per_page, $current_page);
        }

        public function get_columns() {
            $columns = [
                'cb'       => '<input type="checkbox" />', // Para permitir seleções em massa
                'nome'     => 'Nome',
                'email'    => 'Email',
                'quiz_tipo' => 'Tipo de Quiz'
            ];
            return $columns;
        }

        public function get_sortable_columns() {
            $sortable_columns = array(
                'nome' => array('nome', true),
                'email' => array('email', false)
            );
            return $sortable_columns;
        }

        private function record_count() {
            global $wpdb;
            $prefix = $wpdb->prefix."stcode_";
            return $wpdb->get_var("SELECT COUNT(*) FROM {$prefix}quiz_registros");
        }

        private function get_records($per_page = 10, $page_number = 1) {
            global $wpdb;
            $prefix = $wpdb->prefix."stcode_";
            $sql = "SELECT * FROM {$prefix}quiz_registros";

            // Processa os termos de pesquisa
            $search_term = isset($_REQUEST['s']) && is_string($_REQUEST['s']) ? sanitize_text_field(wp_unslash($_REQUEST['s'])) : '';

            // Adiciona condições de pesquisa à consulta SQL
            if (!empty($search_term)) {
                $like = '%' . $wpdb->esc_like($search_term) . '%';
                $sql .= $wpdb->prepare(" WHERE nome LIKE %s OR email LIKE %s", $like, $like);
            }

            $orderby = isset($_REQUEST['orderby']) && is_string($_REQUEST['orderby']) ? $_REQUEST['orderby'] : 'quiz_id';
            $orderby = in_array($orderby, ['quiz_id', 'nome', 'email'], true) ? $orderby : 'quiz_id';
            $direction = isset($_REQUEST['order']) && is_string($_REQUEST['order']) && strtoupper($_REQUEST['order']) === 'DESC' ? 'DESC' : 'ASC';
            $sql .= " ORDER BY $orderby $direction";

            $sql .= " LIMIT $per_page";
            $sql .= ' OFFSET ' . ($page_number - 1) * $per_page;

            return $wpdb->get_results($sql, 'ARRAY_A');
        }

        public function column_default($item, $column_name) {
            switch ($column_name) {
                case 'nome':
                case 'email':
                case 'quiz_tipo':
                    return esc_html($item[$column_name]);
                default:
                    return ''; // Show the whole array for troubleshooting purposes
            }
        }
    }

    // Instanciar e preparar a tabela
    $listaTable = new Quiz_Registros_List_Table();
    $listaTable->prepare_items();
    
    // Renderizar a tabela
    echo '<div class="wrap">
        <h2>Registros do Quiz</h2>
        <button type="submit" name="export_csv" class="button">Exportar para CSV</button>
        <form method="post">';
            $listaTable->search_box('Pesquisar', 'search_id');
            $listaTable->display();
    echo '</form>
    </div>';
}

