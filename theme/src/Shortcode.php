<?php
/**
 * Sistema Shortcode
 *
 * eg.: [custom_cartao cartao_nome=""];
 *
 * @since             0.0.1
 * @author            Sarthemes
 * @package           STCode
 */

namespace STCode;
class Shortcode {
    public function __construct() {
        add_shortcode('cartao', [$this,'cartao_shortcode']);
        add_shortcode('emprestimo', [$this,'emprestimo_shortcode']);
        add_shortcode('banco', [$this,'banco_shortcode']);
    }

    function cartao_shortcode($atts) {
        // Extrai os atributos do shortcode
        $atts = shortcode_atts(
            array(
                'nome' => '', // Atributo para o nome do cartão
            ),
            $atts,
            'cartao'
        );

        // Argumentos da consulta
        $args = array(
            'post_type'      => 'stcode_cartao',
            'order'          => 'DESC',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'no_found_rows'  => true,
            'ignore_sticky_posts' => 1,
            'title' => $atts['nome'], // Usando o título como parâmetro
        );

        // A Query
        $loop = new \WP_Query($args);
        $html = "";

        // O Loop
        if ($loop->have_posts()) {
            while ($loop->have_posts()) {
                $loop->the_post();
                $arr = array(
                    'pros' => get_terms_list_attribute( get_the_ID(), 'pros', 'name', 0),
                    'contras' => get_terms_list_attribute( get_the_ID(), 'contras', 'name', 0),
                );
                $attachment_id = get_post_thumbnail_id( get_the_ID() );
                $image_large_src = wp_get_attachment_image_src( $attachment_id, 'medium' );
                $html .= '<div class="cartao-modulo">
                    <div class="item card-p15">
                        <div class="list">
                            <div class="list-grid two-top">
                                <div class="list__card">
                                    <div class="list-flex">
                                        <div class="list__img ahref">
                                            <a href="'.get_the_permalink().'" target="_blank"><img width="70" height="auto" src="'.$image_large_src[0].'" title="'.get_the_title().'" alt="'.get_the_title().'"></a>
                                        </div>
                                        <div class="list__title">
                                            <div class="item__headline"><div class="ahref"><a href="'.get_the_permalink().'" target="_blank" title="'.get_the_title().'"><h3 class="fetch-title" title="'.get_the_title().'" id="">'.get_the_title().'</h3></a></div></div>
                                            <div class="item__stars">';
                                            $nota = get_post_meta(get_the_ID(), 'stcode_notas', true);
                                            $estrelas_inteiras = floor($nota);
                                            $estrela_parcial = $nota - $estrelas_inteiras;

                                            for ($i = 1; $i <= 5; $i++) {
                                                // Verifica se a estrela é inteira, parcial ou vazia
                                                if ($i <= $estrelas_inteiras) {
                                                    $html .= '<img src="' . STCODE_URI . '/assets/vetors/star.svg" width="18" height="18" alt="Estrela completa">';
                                                } elseif ($i == $estrelas_inteiras + 1 && $estrela_parcial > 0) {
                                                    $html .= '<img src="' . STCODE_URI . '/assets/vetors/star-half.svg" width="18" height="18" alt="Estrela parcialmente completa">';
                                                } else {
                                                    $html .= '<img src="' . STCODE_URI . '/assets/vetors/star-light.svg" width="18" height="18" alt="Estrela vazia">';
                                                }
                                            }
                                            $html .= '<span>'.$nota.'</span>
                                                <div class="help-review">Avaliação Monify <i class="bx bx-check"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list__cta text-center show-for-medium"><div class="ahref"><a class="card-ask-website" href="'.get_post_meta(get_the_ID(), 'stcode_cartao_link', true).'" target="_blank">Peça agora<i class="bx bx-check-shield icon-button"></i></a><div class="color-gray"><small><i class="bx bx-check"></i> URL Verificada</small></div></div></div>
                            </div>
                            <div class="list__details">
                                <div class="wrap__card--row">
                                    <i class="bx bx-calendar-event icon-review"></i>
                                    <b>Anuidade</b> '.get_post_meta(get_the_ID(), 'stcode_anuidade', true).'
                                </div>
                                <div class="wrap__card--row">
                                    <i class="bx bxs-objects-vertical-bottom icon-review"></i>
                                    <div>
                                        <b>Limite de crédito</b>
                                        <div>'.get_post_meta(get_the_ID(), 'stcode_limite_credito', true).'</div>
                                    </div>
                                </div>
                                <div class="wrap__card--row">
                                    <i class="bx bxl-meta icon-review"></i>
                                    <b>Benefícios</b>
                                    <span>'.get_terms_list_attribute( get_the_ID(), 'stcode_beneficios', 'name', 3).'</span>
                                </div>
                                <div class="wrap__card--row">
                                    <i class="bx bx-dollar-circle icon-review"></i>
                                    <b>Renda mínima</b> R$'.get_post_meta(get_the_ID(), 'stcode_renda_minima', true).'
                                </div>
                            </div> 
                        </div>
                        <div class="text-center f-cta">
                            <a href="'.get_the_permalink().'" class="display-flex flex cta__button asx-button" title="Clique para ver mais detalhes">Saiba mais <i class="bx bx-chevron-right"></i></a>
                            <span class="spce-line"></span>
                            <label class="flex cta__button cpr item-label" title="Clique para comparar este cartão" data-card="'.htmlspecialchars(json_encode($arr, JSON_HEX_TAG), ENT_QUOTES, 'UTF-8').'" data-cardurl="'.get_post_meta(get_the_ID(), 'stcode_cartao_link', true).'" data-name="'.get_the_title().'" data-permalink="'.get_the_permalink().'" data-post-id="'.get_the_ID().'">
                                <input type="checkbox" class="item-input" id="input" name="comparar" value="'.get_the_ID().'">Comparar <span class="show-for-medium">cartão</span>
                            </label>
                        </div>
                    </div>
                </div>';
            }
        }

        return $html;

        // Restaura os dados originais do post
        wp_reset_postdata();
    }

    function emprestimo_shortcode($atts) {
        // Extrai os atributos do shortcode
        $atts = shortcode_atts(
            array(
                'nome' => '', // Atributo para o nome do cartão
            ),
            $atts,
            'emprestimo'
        );

        // Argumentos da consulta
        $args = array(
            'post_type'      => 'stcode_emprestimo',
            'order'          => 'DESC',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'no_found_rows'  => true,
            'ignore_sticky_posts' => 1,
            'title' => $atts['nome'], // Usando o título como parâmetro
        );

        // A Query
        $loop = new \WP_Query($args);
        $html = "";

        // O Loop
        if ($loop->have_posts()) {
            while ($loop->have_posts()) {
                $loop->the_post();
                $arr = array(
                    'pros' => get_terms_list_attribute( get_the_ID(), 'pros', 'name', 0),
                    'contras' => get_terms_list_attribute( get_the_ID(), 'contras', 'name', 0),
                    'perfil' => get_terms_list_attribute( get_the_ID(), 'perfil_ideal', 'name', 0)
                );
                $arv = array(
                    'valor' => get_post_meta(get_the_ID(), 'stcode_valor', true),
                    'juros' => get_post_meta(get_the_ID(), 'stcode_juros', true),
                    'tipo' => get_post_meta(get_the_ID(), 'stcode_tipo', true),
                    'prazo' => get_post_meta(get_the_ID(), 'stcode_prazo', true),
                    'parcela' => get_post_meta(get_the_ID(), 'stcode_parcelas', true)
                );
                $attachment_id = get_post_thumbnail_id( get_the_ID() );
                $image_large_src = wp_get_attachment_image_src( $attachment_id, 'medium' );
                $html .= '<div class="cartao-modulo emprestimo">
                    <div class="item card-p15">
                        <div class="list">
                            <div class="list-grid two-top">
                                <div class="list__card">
                                    <div class="list-flex">
                                        <div class="list__title">
                                            <div class="item__headline"><div class="ahref"><a href="'.get_the_permalink().'" target="_blank" title="'.get_the_title().'"><h3 class="fetch-title" title="'.get_the_title().'" id="">'.get_the_title().'</h3></a></div></div>
                                            <div class="item__stars">';
                                            $nota = get_post_meta(get_the_ID(), 'stcode_notas', true);
                                            $estrelas_inteiras = floor($nota);
                                            $estrela_parcial = $nota - $estrelas_inteiras;

                                            for ($i = 1; $i <= 5; $i++) {
                                                // Verifica se a estrela é inteira, parcial ou vazia
                                                if ($i <= $estrelas_inteiras) {
                                                    $html .= '<img src="' . STCODE_URI . '/assets/vetors/star.svg" width="18" height="18" alt="Estrela completa">';
                                                } elseif ($i == $estrelas_inteiras + 1 && $estrela_parcial > 0) {
                                                    $html .= '<img src="' . STCODE_URI . '/assets/vetors/star-half.svg" width="18" height="18" alt="Estrela parcialmente completa">';
                                                } else {
                                                    $html .= '<img src="' . STCODE_URI . '/assets/vetors/star-light.svg" width="18" height="18" alt="Estrela vazia">';
                                                }
                                            }
                                            $html .= '<span>'.$nota.'</span>
                                                <div class="help-review">Avaliação Monify <i class="bx bx-check"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list__cta text-center show-for-medium"><div class="ahref"><a class="card-ask-website" href="'.get_post_meta(get_the_ID(), 'stcode_emprestimo_link', true).'" target="_blank">Abrir Conta<i class="bx bx-check-shield icon-button"></i></a><div class="color-gray"><small><i class="bx bx-check"></i> URL Verificada</small></div></div></div>
                            </div>
                            <div class="list__details">
                                <div class="list__img ahref">
                                    <a href="'.get_the_permalink().'" target="_blank"><img width="70" height="auto" src="'.$image_large_src[0].'" title="'.get_the_title().'" alt="'.get_the_title().'"></a>
                                </div>
                                <div class="wrap__card--row">
                                    <i class=\'bx bx-purchase-tag-alt icon-review\'></i>
                                    <div>
                                        <b>Valor</b>
                                        <div>'.get_post_meta(get_the_ID(), 'stcode_valor', true).'</div>
                                    </div>
                                </div>
                                <div class="wrap__card--row">
                                    <i class=\'bx bx-stats icon-review\'></i>
                                    <b>Taxa de juros</b>
                                    <span>'.get_post_meta(get_the_ID(), 'stcode_juros', true).'</span>
                                </div>
                                <div class="wrap__card--row">
                                    <i class=\'bx bx-time icon-review\'></i>
                                    <b>Prazo</b> '.get_post_meta(get_the_ID(), 'stcode_prazo', true).'
                                </div>
                            </div> 
                        </div>
                        <div class="text-center f-cta">
                            <button type="button" class="display-flex flex cta__button asx-button" title="Clique para ver mais detalhes">Ver mais detalhes <i class="bx bx-chevron-down"></i></button>
                            <label class="flex cta__button cpr item-label" title="Clique para comparar este empréstimo" data-card="'.htmlspecialchars(json_encode($arr, JSON_HEX_TAG), ENT_QUOTES, 'UTF-8').'" data-row="'.htmlspecialchars(json_encode($arv, JSON_HEX_TAG), ENT_QUOTES, 'UTF-8').'" data-cardurl="'.get_post_meta(get_the_ID(), 'stcode_cartao_link', true).'" data-name="'.get_the_title().'" data-slug="'.get_post_field('post_name', get_the_ID()).'" data-permalink="'.get_the_permalink().'" data-post-id="'.get_the_ID().'">
                                <input type="checkbox" class="item-input" id="input" name="comparar" value="'.get_the_ID().'">Comparar <span class="show-for-medium">empréstimo</span>
                            </label>
                        </div>
                        <div class="reviews__extra">
                            <section class="accordion">
                                <div class="tab">
                                    <label for="cb1_'.get_post_meta(get_the_ID(), 'titulo_original', true).'" class="tab_label">
                                        <input id="cb1_'.get_post_meta(get_the_ID(), 'titulo_original', true).'" type="checkbox" autocomplete="off">
                                        <span class="tab_title">Documentos necessários</span>
                                        <span class="tab_content">';
                                        $terms = get_the_terms(get_the_ID(),'documentos');
                                        if (!empty($terms) && !is_wp_error($terms)) {
                                            $html .= '<ul>';
                                            foreach( $terms as $term ) {
                                               $html .= '<li><p>'.$term->name.'</p></li>';
                                            }
                                            $html .= '</ul>';
                                        }
                                        $html .= '</span>
                                    </label>
                                </div>
                                <div class="tab">
                                    <label for="cb2_'.get_post_meta(get_the_ID(), 'titulo_original', true).'" class="tab_label">
                                        <input id="cb2_'.get_post_meta(get_the_ID(), 'titulo_original', true).'" type="checkbox" autocomplete="off">
                                        <span class="tab_title">Tipo de empréstimo</span>
                                        <span class="tab_content"><ul>';
                                        $tipos_empre = explode("\n", get_post_meta(get_the_ID(), 'stcode_tipo_emprestimo', true));
                                        if ( !empty($tipos_empre) ) {
                                            $html .= '<ul>';
                                            foreach( $tipos_empre as $tipo ) {
                                               $html .= '<li><p>'.$tipo.'</p></li>';
                                            }
                                            $html .= '</ul>';
                                        }
                                        $html .= '</span>
                                    </label>
                                </div>
                                <div class="tab">
                                    <label for="cb3_'.get_post_meta(get_the_ID(), 'titulo_original', true).'" class="tab_label">
                                        <input id="cb3_'.get_post_meta(get_the_ID(), 'titulo_original', true).'" type="checkbox" autocomplete="off">
                                        <span class="tab_title">Prós e Contras</span>
                                        <span class="tab_content"><h2>Prós</h2>';
                                        $terms_pros = get_the_terms(get_the_ID(),'pros');
                                        if (!empty($terms_pros) && !is_wp_error($terms_pros)) {
                                            $html .= '<ul>';
                                            foreach( $terms_pros as $term ) {
                                               $html .= '<li><p>'.$term->name.'</p></li>';
                                            }
                                            $html .= '</ul>';
                                        }
                                        $html .= '<h2>Contras</h2>';
                                        $terms_contras = get_the_terms(get_the_ID(),'contras');
                                        if (!empty($terms_contras) && !is_wp_error($terms_contras)) {
                                            $html .= '<ul>';
                                            foreach( $terms_contras as $term ) {
                                               $html .= '<li><p>'.$term->name.'</p></li>';
                                            }
                                            $html .= '</ul>';
                                        }
                                        $html .= '</span>
                                    </label>
                                </div>
                                <div class="tab">
                                    <label for="cb4_'.get_post_meta(get_the_ID(), 'titulo_original', true).'" class="tab_label">
                                        <input id="cb4_'.get_post_meta(get_the_ID(), 'titulo_original', true).'" type="checkbox" autocomplete="off">
                                        <span class="tab_title">Perfil ideal</span>
                                        <span class="tab_content">';
                                        $terms_perfil = get_the_terms(get_the_ID(),'perfil_ideal');
                                        if (!empty($terms_perfil) && !is_wp_error($terms_perfil)) {
                                            $html .= '<ul>';
                                            foreach( $terms_perfil as $term ) {
                                               $html .= '<li><p>'.$term->name.'</p></li>';
                                            }
                                            $html .= '</ul>';
                                        }
                                        $html .= '</span>
                                    </label>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>';
            }
        }

        return $html;

        // Restaura os dados originais do post
        wp_reset_postdata();
    }

    function banco_shortcode($atts) {
        // Extrai os atributos do shortcode
        $atts = shortcode_atts(
            array(
                'nome' => '', // Atributo para o nome do cartão
            ),
            $atts,
            'banco'
        );

        // Argumentos da consulta
        $args = array(
            'post_type'      => 'stcode_conta_digital',
            'order'          => 'DESC',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'no_found_rows'  => true,
            'ignore_sticky_posts' => 1,
            'title' => $atts['nome'], // Usando o título como parâmetro
        );

        // A Query
        $loop = new \WP_Query($args);
        $html = "";

        // O Loop
        if ($loop->have_posts()) {
            while ($loop->have_posts()) {
                $loop->the_post();
                $arr = array(
                    'pros' => get_terms_list_attribute( get_the_ID(), 'pros', 'name', 0),
                    'contras' => get_terms_list_attribute( get_the_ID(), 'contras', 'name', 0),
                    'perfil' => get_terms_list_attribute( get_the_ID(), 'perfil_ideal', 'name', 0)
                );
                $arv = array(
                    'valor' => get_post_meta(get_the_ID(), 'stcode_valor', true),
                    'juros' => get_post_meta(get_the_ID(), 'stcode_juros', true),
                    'tipo' => get_post_meta(get_the_ID(), 'stcode_tipo', true),
                    'prazo' => get_post_meta(get_the_ID(), 'stcode_prazo', true),
                    'parcela' => get_post_meta(get_the_ID(), 'stcode_parcelas', true)
                );
                $attachment_id = get_post_thumbnail_id( get_the_ID() );
                $image_large_src = wp_get_attachment_image_src( $attachment_id, 'medium' );
                $html .= '<div class="cartao-modulo emprestimo">
                    <div class="item card-p15">
                        <div class="list">
                            <div class="list-grid two-top">
                                <div class="list__card">
                                    <div class="list-flex">
                                        <div class="list__title">
                                            <div class="item__headline"><div class="ahref"><a href="'.get_the_permalink().'" target="_blank" title="'.get_the_title().'"><h3 class="fetch-title" title="'.get_the_title().'" id="">'.get_the_title().'</h3></a></div></div>
                                            <div class="item__stars">';
                                            $nota = get_post_meta(get_the_ID(), 'stcode_notas', true);
                                            $estrelas_inteiras = floor($nota);
                                            $estrela_parcial = $nota - $estrelas_inteiras;

                                            for ($i = 1; $i <= 5; $i++) {
                                                // Verifica se a estrela é inteira, parcial ou vazia
                                                if ($i <= $estrelas_inteiras) {
                                                    $html .= '<img src="' . STCODE_URI . '/assets/vetors/star.svg" width="18" height="18" alt="Estrela completa">';
                                                } elseif ($i == $estrelas_inteiras + 1 && $estrela_parcial > 0) {
                                                    $html .= '<img src="' . STCODE_URI . '/assets/vetors/star-half.svg" width="18" height="18" alt="Estrela parcialmente completa">';
                                                } else {
                                                    $html .= '<img src="' . STCODE_URI . '/assets/vetors/star-light.svg" width="18" height="18" alt="Estrela vazia">';
                                                }
                                            }
                                            $html .= '<span>'.$nota.'</span>
                                                <div class="help-review">Avaliação Monify <i class="bx bx-check"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list__cta text-center show-for-medium"><div class="ahref"><a class="card-ask-website" href="'.get_post_meta(get_the_ID(), 'stcode_banco_link', true).'" target="_blank">Abrir Conta<i class="bx bx-check-shield icon-button"></i></a><div class="color-gray"><small><i class="bx bx-check"></i> URL Verificada</small></div></div></div>
                            </div>
                            <div class="list__details">
                                <div class="list__img ahref">
                                    <a href="'.get_the_permalink().'" target="_blank"><img width="70" height="auto" src="'.$image_large_src[0].'" title="'.get_the_title().'" alt="'.get_the_title().'"></a>
                                </div>
                                <div class="wrap__card--row">
                                    <i class=\'bx bx-purchase-tag-alt icon-review\'></i>
                                    <div>
                                        <b>Valor</b>
                                        <div>'.get_post_meta(get_the_ID(), 'stcode_valor', true).'</div>
                                    </div>
                                </div>
                                <div class="wrap__card--row">
                                    <i class=\'bx bx-stats icon-review\'></i>
                                    <b>Taxa de juros</b>
                                    <span>'.get_post_meta(get_the_ID(), 'stcode_juros', true).'</span>
                                </div>
                                <div class="wrap__card--row">
                                    <i class=\'bx bx-time icon-review\'></i>
                                    <b>Prazo</b> '.get_post_meta(get_the_ID(), 'stcode_prazo', true).'
                                </div>
                            </div> 
                        </div>
                        <div class="text-center f-cta">
                            <button type="button" class="display-flex flex cta__button asx-button" title="Clique para ver mais detalhes">Ver mais detalhes <i class="bx bx-chevron-down"></i></button>
                            <label class="flex cta__button cpr item-label" title="Clique para comparar este empréstimo" data-card="'.htmlspecialchars(json_encode($arr, JSON_HEX_TAG), ENT_QUOTES, 'UTF-8').'" data-row="'.htmlspecialchars(json_encode($arv, JSON_HEX_TAG), ENT_QUOTES, 'UTF-8').'" data-cardurl="'.get_post_meta(get_the_ID(), 'stcode_cartao_link', true).'" data-name="'.get_the_title().'" data-slug="'.get_post_field('post_name', get_the_ID()).'" data-permalink="'.get_the_permalink().'" data-post-id="'.get_the_ID().'">
                                <input type="checkbox" class="item-input" id="input" name="comparar" value="'.get_the_ID().'">Comparar <span class="show-for-medium">empréstimo</span>
                            </label>
                        </div>
                        <div class="reviews__extra">
                            <section class="accordion">
                                <div class="tab">
                                    <label for="cb1_'.get_post_meta(get_the_ID(), 'titulo_original', true).'" class="tab_label">
                                        <input id="cb1_'.get_post_meta(get_the_ID(), 'titulo_original', true).'" type="checkbox" autocomplete="off">
                                        <span class="tab_title">Documentos necessários</span>
                                        <span class="tab_content">';
                                        $terms = get_the_terms(get_the_ID(),'documentos');
                                        if (!empty($terms) && !is_wp_error($terms)) {
                                            $html .= '<ul>';
                                            foreach( $terms as $term ) {
                                               $html .= '<li><p>'.$term->name.'</p></li>';
                                            }
                                            $html .= '</ul>';
                                        }
                                        $html .= '</span>
                                    </label>
                                </div>
                                <div class="tab">
                                    <label for="cb2_'.get_post_meta(get_the_ID(), 'titulo_original', true).'" class="tab_label">
                                        <input id="cb2_'.get_post_meta(get_the_ID(), 'titulo_original', true).'" type="checkbox" autocomplete="off">
                                        <span class="tab_title">Tipo de empréstimo</span>
                                        <span class="tab_content"><ul>';
                                        $tipos_empre = explode("\n", get_post_meta(get_the_ID(), 'stcode_tipo_emprestimo', true));
                                        if ( !empty($tipos_empre) ) {
                                            $html .= '<ul>';
                                            foreach( $tipos_empre as $tipo ) {
                                               $html .= '<li><p>'.$tipo.'</p></li>';
                                            }
                                            $html .= '</ul>';
                                        }
                                        $html .= '</span>
                                    </label>
                                </div>
                                <div class="tab">
                                    <label for="cb3_'.get_post_meta(get_the_ID(), 'titulo_original', true).'" class="tab_label">
                                        <input id="cb3_'.get_post_meta(get_the_ID(), 'titulo_original', true).'" type="checkbox" autocomplete="off">
                                        <span class="tab_title">Prós e Contras</span>
                                        <span class="tab_content"><h2>Prós</h2>';
                                        $terms_pros = get_the_terms(get_the_ID(),'pros');
                                        if (!empty($terms_pros) && !is_wp_error($terms_pros)) {
                                            $html .= '<ul>';
                                            foreach( $terms_pros as $term ) {
                                               $html .= '<li><p>'.$term->name.'</p></li>';
                                            }
                                            $html .= '</ul>';
                                        }
                                        $html .= '<h2>Contras</h2>';
                                        $terms_contras = get_the_terms(get_the_ID(),'contras');
                                        if (!empty($terms_contras) && !is_wp_error($terms_contras)) {
                                            $html .= '<ul>';
                                            foreach( $terms_contras as $term ) {
                                               $html .= '<li><p>'.$term->name.'</p></li>';
                                            }
                                            $html .= '</ul>';
                                        }
                                        $html .= '</span>
                                    </label>
                                </div>
                                <div class="tab">
                                    <label for="cb4_'.get_post_meta(get_the_ID(), 'titulo_original', true).'" class="tab_label">
                                        <input id="cb4_'.get_post_meta(get_the_ID(), 'titulo_original', true).'" type="checkbox" autocomplete="off">
                                        <span class="tab_title">Perfil ideal</span>
                                        <span class="tab_content">';
                                        $terms_perfil = get_the_terms(get_the_ID(),'perfil_ideal');
                                        if (!empty($terms_perfil) && !is_wp_error($terms_perfil)) {
                                            $html .= '<ul>';
                                            foreach( $terms_perfil as $term ) {
                                               $html .= '<li><p>'.$term->name.'</p></li>';
                                            }
                                            $html .= '</ul>';
                                        }
                                        $html .= '</span>
                                    </label>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>';
            }
        }

        return $html;

        // Restaura os dados originais do post
        wp_reset_postdata();
    }

}

