<?php
/**
 * Cartão de Crédito [ Registro de cartões ]
 *
 * @author Sarthemes <sarthemes@gmail.com>
 * @link https://sarthemes.com/
 * @copyright 2020-2024 Sarthemes
 */

use STCode\MetafieldsPosts;

class Questionario {

    private static $instance;
    private function __construct() {
        add_action('init', [$this,'registrar_post_type']);
        add_action('add_meta_boxes', [$this,'adicionar_campos_customizados']);
        add_action('save_post', [$this,'salvar_campos_customizados']);
    }

    public static function get_instance() 
    {
        if ( null == self::$instance ) {
            self::$instance = new Questionario();
        }
        return self::$instance;
    }

    public function registrar_post_type() {
        $labels = array(
            'name'               => 'Questionários',
            'singular_name'      => 'Questionário',
            'menu_name'          => 'Questionário',
            'add_new'            => 'Adicionar',
            'add_new_item'       => 'Adicionar um novo',
            'edit_item'          => 'Editar questionário',
            'new_item'           => 'Novo',
            'view_item'          => 'Ver',
            'search_items'       => 'Buscar Questionário',
            'not_found'          => 'Nenhum questionário encontrado',
            'not_found_in_trash' => 'Nenhum questionário encontrado na lixeira',
        );

        $args = array(
            'labels'             => $labels,
            'labels'              => $labels,
            'supports'            => array('title'),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 4,
            'menu_icon'           => 'dashicons-stcode-question',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => false,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => false,
            'capability_type'     => 'post',
            'publicly_queryable'  => false,
        );

        register_post_type('stcode_questionarios', $args);
    }

    // Adicionar campos customizados
    public function adicionar_campos_customizados() {
        add_meta_box('campos_quiz_e_resultados','Informações',[$this,'mostrar_informacoes'],'stcode_questionarios','normal','default');
        add_meta_box('campos_questionarios','Questionarios',[$this,'mostrar_campos_customizados'],'stcode_questionarios','normal','default');
    }

    public function mostrar_campos_customizados($post) {
        // Nonce security
        wp_nonce_field('_cartao_nonce', 'cartao_nonce'); 
        $postmneta = stcode_get_all_questions($post->ID);
        ?>
        <table id="questionsContainer" width="100%" class="stcode_table_player">
            <thead>
                <tr>
                    <th>Pergunta</th>
                    <th>Respostas</th>
                    <th class="controle">Controle</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if($postmneta) :
                // Ordenar as perguntas pelo question_type
                foreach ($postmneta as $index => $field) { ?>
                    <tr class="tritem">
                        <td class="question">
                            <input type="text" class="widefat" name="question[]" placeholder="Digite a pergunta..." value="<?php echo esc_attr($field['question_title']); ?>" />
                            <input type="hidden" name="question_id[]" value="<?php echo esc_attr($field['question_id']); ?>">
                        </td>
                        <td class="answer">
                            <button class="button add-answer" type="button">Adicionar Resposta</button>
                            <?php 
                            if (!empty($field['answer'])) :
                                foreach (unserialize($field['answer']) as $answer) : ?>
                                    <input type="text" class="widefat" name="answer[<?php echo $index; ?>][]" placeholder="Digite a resposta..." value="<?php echo esc_attr($answer); ?>" />
                                <?php endforeach;
                            endif; ?>
                        </td>
                        <td class="controle"><a class="button remove-row" href="#">Excluir</a></td>
                    </tr>
                <?php }
            else : ?>
                <!-- Se não houver perguntas salvas -->
                <tr class="tritem">
                    <td class="question">
                        <input type="text" class="widefat" name="question[]" placeholder="Digite a pergunta..." />
                        <input type="hidden" name="question_id[]">
                    </td>
                    <td class="answer">
                        <button class="button add-answer" type="button">Adicionar Resposta</button>
                    </td>
                    <td class="controle"><a class="button remove-row" href="#">Excluir</a></td>
                </tr>
            <?php endif; ?>
            <tr class="empty-row screen-reader-text tritem">
                <td class="question">
                    <input type="text" class="widefat" name="question[]" placeholder="Digite a pergunta..." />
                    <input type="hidden" name="question_id[]">
                </td>
                <td class="answer">
                    <button class="button add-answer" type="button">Adicionar Resposta</button>
                </td>
                <td class="controle"><a class="button remove-row" href="#">Excluir</a></td>
            </tr>
            </tbody>
        </table>

        <!-- Link Add Row -->
        <p class="repeater"><a id="add-row" class="add_row" href="#">Adicionar uma nova pergunta</a></p>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                // Adiciona uma nova pergunta
                $('#add-row').on('click', function() {
                    var row = $('.empty-row.screen-reader-text').clone(true);
                    row.removeClass('empty-row screen-reader-text');
                    $('#questionsContainer tbody').append(row);
                    
                    // Defina o question_type com base na posição da nova pergunta
                    var questionIndex = $('#questionsContainer tbody tr').length - 1;
                    row.find('.question input[name="question_id[]"]').val(questionIndex);
                    
                    return false;
                });

                // Remove uma pergunta
                $(document).on('click', '.remove-row', function() {
                    $(this).closest('tr').remove();
                    return false;
                });

                // Adiciona uma nova resposta
                $(document).on('click', '.add-answer', function() {
                    // Encontra o índice da pergunta correspondente
                    var questionIndex = $(this).closest('tr').index();
                    // Cria o campo de resposta com o nome adequado
                    var answerInput = $('<input type="text" class="widefat" name="answer[' + questionIndex + '][]" placeholder="Digite a resposta..." />');
                    $(this).parent().append(answerInput);
                    return false;
                });
            });
        </script>
        <?php
    }

    public function mostrar_informacoes($post) {
        $opcs = array(
            array(
                'type' => 'heading',
                'text' => 'Mensagem: Começo do Quiz',
            ),
            array(
                'id'     => 'stcode_quiz_title',
                'type'   => 'text',
                'label'  => 'Titulo:'
            ),
            array(
                'id'     => 'stcode_quiz_desc',
                'type'   => 'textarea',
                'label'  => 'Descrição:',
            ),
            array(
                'id'     => 'stcode_quiz_mindesc',
                'type'   => 'text',
                'label'  => 'Descrição curta:',
            ),
            array(
                'type' => 'heading',
                'text' => 'Mensagem: Resultado do Quiz',
            ),
            array(
                'id'     => 'stcode_result_title',
                'type'   => 'text',
                'label'  => 'Titulo:'
            ),
            array(
                'id'     => 'stcode_result_desc',
                'type'   => 'textarea',
                'label'  => 'Descrição:',
            ),
            array(
                'id'     => 'stcode_result_mindesc',
                'type'   => 'text',
                'label'  => 'Descrição curta:',
            ),
            array(
                'id'        => 'stcode_result_image',
                'type'      => 'upload',
                'label'     => 'Imagem:',
            ),
            array(
                'id'        => 'stcode_post_link',
                'tipo'      => 'post',
                'type'      => 'post',
                'label'     => 'Postagem Vinculada:',
            ),
            array(
                'id'        => 'stcode_button_name',
                'type'      => 'text',
                'label'     => 'Nome do Botão:',
            ),
        );

        new MetafieldsPosts($opcs);
    }

    public function salvar_campos_customizados($post_id) {
        global $wpdb;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
        if (!isset( $_POST['cartao_nonce'] ) || ! wp_verify_nonce( $_POST['cartao_nonce'], '_cartao_nonce') ) return;
        if (!current_user_can('edit_post', $post_id ) ) return;

        // Verifica se os campos de pergunta foram enviados
        if (isset($_POST['question']) && isset($_POST['answer'])) {
            
            $questions = [];
            $deletou = false;
            $qntdDeletes = 0;
            
            // Obtém todas as perguntas existentes antes de qualquer modificação
            $existing_questions = stcode_get_all_questions($post_id);

            // Combina as perguntas e respostas em um array associativo
            foreach ($_POST['question'] as $i => $question) {
                if (!empty($question)) {
                    // Inicializa um array vazio para as respostas desta pergunta
                    $answers = [];

                    // Verifica se existem respostas correspondentes para esta pergunta
                    if (isset($_POST['answer'][$i])) {
                        // Itera sobre todas as respostas desta pergunta
                        foreach ($_POST['answer'][$i] as $answer) {
                            // Verifica se a resposta não está vazia
                            if (!empty($answer)) {
                                // Adiciona a resposta ao array de respostas
                                $answers[] = sanitize_text_field($answer);
                            }
                        }
                    }

                    // Verifica se a pergunta já existe no banco de dados
                    if (stcode_question_exists($post_id, $question)) {
                        // Atualiza os dados da pergunta
                        stcode_update_questions_answer($post_id, $question, $answers, $i);
                    } elseif (!empty($answers)) {
                        // Insere os dados da pergunta
                        stcode_insert_questions_answer($post_id, $question, $answers, $i);
                    }
                } else {
                    // Se a pergunta estiver vazia, marque-a para exclusão
                    $deletou = true;
                    $qntdDeletes++;
                }
            }

            // Verifica se alguma pergunta precisa ser excluída
            if ($deletou) {
                // Itera sobre todas as perguntas existentes
                foreach ($existing_questions as $existing_question) {
                    // Verifica se a pergunta atual não está presente no loop de iteração
                    if (!in_array($existing_question['question_title'], $_POST['question'])) {
                        // Exclui a pergunta do banco de dados
                        stcode_delete_questions_answer($post_id, $existing_question['question_title']);
                    }
                }
            }
        }

        // Array Post-meta
        $update_post_meta = array(
            'stcode_quiz_title','stcode_quiz_desc','stcode_quiz_mindesc','stcode_button_name','stcode_result_title','stcode_result_desc','stcode_result_mindesc','stcode_result_image','stcode_post_link'
        );

        // Generate POST @since 2.1.3
        foreach ($update_post_meta as $i => $key) {
            if ( isset( $_POST[$key] ) ) update_post_meta( $post_id, $key, esc_attr( $_POST[$key] ) ); else delete_post_meta( $post_id, $key );
        }
    }
}

Questionario::get_instance();