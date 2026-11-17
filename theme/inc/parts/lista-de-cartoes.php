<?php get_header(); ?>
<main class="container monify-card-catalog">
	<div class="stcode_heading">
		<h2 class="title">O que você mais procura em um cartão de crédito?</h2>
	</div>
	<?php
    $filter_value = static function ($key, $default = '') {
        return isset($_GET[$key]) && is_string($_GET[$key])
            ? sanitize_text_field(wp_unslash($_GET[$key]))
            : $default;
    };
    $min = max(0, (int) $filter_value('min_price'));
    $max = max(0, (int) $filter_value('max_price', '100000'));
    if ($min > $max) {
        [$min, $max] = [$max, $min];
    }
    $bandeira_get = explode(',', $filter_value('stcode_bandeiras'));
    $beneficio_get = explode(',', $filter_value('stcode_beneficios'));
    $categoria_get = explode(',', $filter_value('stcode_categoria'));
    $search = $filter_value('search');
	?>
	<div class="row">
		<div class="col-12 col-lg-2 left-col">
			<div class="shop__filters-left">
				<div class="filter nopading-top">
					<label class="search"><input placeholder="Digite para buscar.." aria-label="Buscar cartões" name="search" class="sf-input-text" type="text" value="<?php echo esc_attr($search); ?>"></label>
				</div>
                <details class="monify-catalog-filters" open>
                    <summary>Filtros</summary>
				<div class="filter">
					<div class="filter__category">Benefícios</div>
					<div class="filter_content">
						<?php
						$beneficios = get_terms(array(
							'taxonomy' => 'stcode_beneficios',
							'hide_empty' => false
						));
						if (!empty($beneficios) && !is_wp_error($beneficios)) :
						    foreach ($beneficios as $beneficio) :
						        // Verifica se a banderia tem um pai
						        $parent_class = '';
						        if ($beneficio->parent != 0) {
						            $parent_class = ' filter_child'; // Adiciona a classe se tiver pai
						        }
						        // Monta o HTML com base na presença do pai
						        echo '<div class="filter__rule' . esc_attr($parent_class) . '"><input id="filter__input-' . esc_attr($beneficio->term_id) . '" name="stcode_beneficios" type="checkbox" class="filter__rule-input" data-keynormalizedname="stcode_beneficios" value="' . esc_attr($beneficio->slug) . '"'.(in_array($beneficio->slug, $beneficio_get) ? 'checked="checked"' : null ).'><label for="filter__input-' . esc_attr($beneficio->term_id) . '" class="filter__rule-label">' . esc_html($beneficio->name) . '</label></div>';
						    endforeach;
						endif;
						?>
					</div>
				</div>
				<div class="filter">
					<div class="filter__category">Categoria</div>
					<div class="filter_content">
						<?php
						$categorias = get_terms(array(
							'taxonomy' => 'stcode_categoria',
							'hide_empty' => false
						));
						if (!empty($categorias) && !is_wp_error($categorias)) :
						    foreach ($categorias as $categoria) :
						        // Verifica se a banderia tem um pai
						        $parent_class = '';
						        if ($categoria->parent != 0) {
						            $parent_class = ' filter_child'; // Adiciona a classe se tiver pai
						        }
						        // Monta o HTML com base na presença do pai
						        echo '<div class="filter__rule' . esc_attr($parent_class) . '"><input id="filter__input-' . esc_attr($categoria->term_id) . '" name="stcode_categoria" type="checkbox" class="filter__rule-input" data-keynormalizedname="stcode_categoria" value="' . esc_attr($categoria->slug) . '" '.(in_array($categoria->slug, $categoria_get) ? 'checked="checked"' : null ).'><label for="filter__input-' . esc_attr($categoria->term_id) . '" class="filter__rule-label">' . esc_html($categoria->name) . '</label></div>';
						    endforeach;
						endif;
						?>
					</div>
				</div>
				<div class="filter">
					<div class="filter__category">Bandeira</div>
					<div class="filter_content">
						<?php
						$bandeiras = get_terms(array(
							'taxonomy' => 'stcode_bandeiras',
							'hide_empty' => false
						));
						if (!empty($bandeiras) && !is_wp_error($bandeiras)) :
						    foreach ($bandeiras as $bandeira) :
						        // Verifica se a banderia tem um pai
						        $parent_class = '';
						        if ($bandeira->parent != 0) {
						            $parent_class = ' filter_child'; // Adiciona a classe se tiver pai
						        }
						        // Monta o HTML com base na presença do pai
						        echo '<div class="filter__rule' . esc_attr($parent_class) . '"><input id="filter__input-' . esc_attr($bandeira->term_id) . '" name="stcode_bandeiras" type="checkbox" class="filter__rule-input" data-keynormalizedname="stcode_bandeiras" value="' . esc_attr($bandeira->slug) . '" '.(in_array($bandeira->slug, $bandeira_get) ? 'checked="checked"' : null ).'><label for="filter__input-' . esc_attr($bandeira->term_id) . '" class="filter__rule-label">' . esc_html($bandeira->name) . '</label></div>';
						    endforeach;
						endif;
						?>
					</div>
				</div>
				<div class="filter">
					<div class="filter__category">Renda Mensal</div>
					<div class="filter__rule">
						<div class="range_container filter_range_preco" data-class="filter_range_preco">
							<div class="sliders_control">
								<input class="filter_range fromSlider" aria-label="Renda mínima no filtro" type="range" value="<?php echo $min; ?>" min="0" max="100000">
								<input class="filter_range toSlider" aria-label="Renda máxima no filtro" type="range" value="<?php echo $max; ?>" min="0" max="100000" style="z-index: 2;">
							</div>
							<div class="form_control">
								<div class="form_control_container">
									<span class="form_control_container__time">Mínimo:</span>
									<input class="form_control_container__time__input filter_range fromInput" aria-label="Valor mínimo de renda" type="number" value="<?php echo $min; ?>" min="0" max="100000">
								</div>
								<div class="form_control_container">
									<span class="form_control_container__time">Máximo:</span>
									<input class="form_control_container__time__input filter_range toInput" aria-label="Valor máximo de renda" type="number" value="<?php echo $max; ?>" min="0" max="100000">
								</div>
							</div>
							<input type="checkbox" name="_preco-0-1200" class="filters__filter__list__item__checkbox filter_range_checkbox" id="_preco-0-1200" value="0-1200" data-keynormalizedname="_preco" data-name="0-100">
						</div>
					</div>
				</div>
				<div class="filter-reset">
					<input type="submit" class="search-filter-reset" name="ct_reset_filter" value="Resetar filtro">
				</div>
                </details>
			</div>
		</div>
		<div class="col-12 col-lg-10 right-col">
			<div class="overlay">
			    <div class="loading-balls">
			        <div></div>
			        <div></div>
			        <div></div>
			    </div>
			</div>
			<div class="listagem tax-cartoes-itens">
				<div class="l-cartao l-cartao-one">
					<?php
					$paged = max(1, min(1000, (int) $filter_value('pagina', (string) (get_query_var('paged') ?: 1))));

					$args = array(
					    'post_type'      => 'stcode_cartao',
					    'paged'          => $paged,
					    'posts_per_page' => 16,
					    'orderby'        => 'date',
					);

					// Pesquisa caso haja
					if (!empty($search)) {
					    $args['s'] = $search;
					}

					// Adicione a lógica para incluir taxonomias baseadas nos parâmetros GET
					$tax_query = array();

					$taxonomies = array(
					    'stcode_categoria',
					    'stcode_bandeiras',
					    'stcode_beneficios'
					);

					foreach ($taxonomies as $taxonomy) {
					    $value = $filter_value($taxonomy);
                        if ($value !== '') {
					        $tax_query[] = array(
					            'taxonomy' => $taxonomy,
					            'field'    => 'slug',
					            'terms'    => array_map('sanitize_title', explode(',', $value)),
					        );
					    }
					}

					// Adicione a tax_query aos argumentos da consulta principal
					if (!empty($tax_query)) {
					    $args['tax_query'] = $tax_query;
					}

					$args['meta_query'] = array(
				        array(
				            'key' => 'stcode_renda_minima',
				            'value' => array($min, $max), // Faixa de preços (mínimo e máximo)
				            'type' => 'NUMERIC',
				            'compare' => 'BETWEEN',
				        ),
				    );

					// Continue com o seu loop principal
					$loop = new WP_Query($args);
					$html = '';
					if ($loop->have_posts()) :
					    while ($loop->have_posts()) : $loop->the_post();
					    	$image_url = esc_url(get_solo_image(get_the_ID())) ?: esc_url(STCODE_URI . '/assets/vetors/credit.svg');
					    	$html .= '<div class="cartao-modulo">
			                    <div class="item card-p15">
			                        <div class="list">
			                            <div class="list-grid two-top">
			                                <div class="list__card">
			                                    <div class="list-flex">
			                                        <div class="list__img ahref">
			                                            <a href="'.get_the_permalink().'" target="_blank"><img width="70" height="auto" src="'.$image_url.'" title="'.get_the_title().'" alt="'.get_the_title().'"></a>
			                                        </div>
			                                        <div class="list__title">
			                                            <div class="item__headline"><div class="ahref"><a href="'.get_the_permalink().'" target="_blank" title="'.get_the_title().'"><h3 class="fetch-title" title="'.get_the_title().'" id="">'.get_the_title().'</h3></a></div></div>
			                                            <div class="item__stars">';
			                                            $nota = max(0, min(5, (float) get_post_meta(get_the_ID(), 'stcode_notas', true)));
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
			                            <a href="'.get_the_permalink().'" class="display-flex flex cta__button asx-button" title="Clique para ver mais detalhes">Ver mais detalhes  <i class="bx bx-chevron-right"></i></a>
			                            <span class="spce-line"></span>
			                            <label class="flex cta__button item-label" title="Clique para comparar este cartão" data-name="'.get_the_title().'" data-slug="'.get_post_field('post_name', get_the_ID()).'" data-permalink="'.get_the_permalink().'" data-post-id="'.get_the_ID().'">
			                                <input type="checkbox" class="item-input" name="comparar" value="'.get_the_ID().'">Comparar <span class="show-for-medium">cartão</span>
			                            </label>
			                        </div>
			                    </div>
			                </div>';
					    endwhile;
					else:
                        $html = '<p>Nenhum cartão encontrado.</p>';
                    endif;
					echo $html;
					// Restaura os dados originais do post
					wp_reset_postdata();
					?>
					<?php if ($loop->max_num_pages > 1): ?>
                        <nav class="monify-catalog-pages" aria-label="Páginas dos cartões">
                            <?php
                            $page_filters = [];
                            foreach (['search', 'stcode_categoria', 'stcode_bandeiras', 'stcode_beneficios', 'min_price', 'max_price'] as $key) {
                                $value = $filter_value($key);
                                if ($value !== '') {
                                    $page_filters[$key] = $value;
                                }
                            }
                            $base = add_query_arg($page_filters + ['pagina' => '__monify_page__'], home_url('/comparador-de-cartao-de-credito'));
                            echo wp_kses_post(paginate_links([
                                'base' => str_replace('pagina=__monify_page__', 'pagina=%#%', $base),
                                'format' => '',
                                'current' => $paged,
                                'total' => $loop->max_num_pages,
                                'prev_text' => 'Anterior',
                                'next_text' => 'Próxima',
                            ]));
                            ?>
                        </nav>
                    <?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div id="main-extra-cards" class="cell small-12 medium-12 large-12">
		<div class="faq__summary faq__row">
			<span class="faq__title">Perguntas frequentes</span>
			<ul class="accordion faq__summary--content" itemscope="" itemtype="https://schema.org/FAQPage" role="tablist">
				<li class="accordion-item" data-accordion-item="" itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
					<a href="#" class="accordion-title" itemprop="name" aria-controls="pmg2wg-accordion" role="tab" id="pmg2wg-accordion-label" aria-expanded="false" aria-selected="false">Como solicitar um cartão de crédito? <i class='bx bx-chevron-down'></i></a>
					<div class="accordion-content" data-tab-content="" itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" role="tabpanel" aria-labelledby="pmg2wg-accordion-label" aria-hidden="true" id="pmg2wg-accordion" style="display: none;">
						<div itemprop="text">
							<p>Pode solicitar um cartão de crédito a pessoa que cumprir com os requisitos exigidos pelas instituições financeiras, como:</p>
							<ul>
								<li aria-level="1">Ter idade a partir de 18 anos;</li>
								<li aria-level="1">Apresentar documentos de identificação (RG/CPF);</li>
								<li aria-level="1">Comprovante de residência;</li>
								<li aria-level="1">Ter uma fonte de renda mínima;</li>
								<li aria-level="1">Informar contatos principais (telefone/e-mail).</li>
								</ul>
								<p>Além das exigências para solicitar, outros pontos são considerados para melhorar as chances de aprovação do cartão, como:</p>
								<ul>
								<li aria-level="1">Estar com o nome limpo, sem dívidas;</li>
								<li aria-level="1">Ter um bom Score de Crédito.</li>
							</ul>
							<p>Por fim, considere que alguns requisitos podem variar de acordo com cada emissor de cartão.</p>
						</div>
					</div>
				</li>
				<li class="accordion-item" data-accordion-item="" itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
					<a href="#" class="accordion-title" itemprop="name" aria-controls="a4v39v-accordion" role="tab" id="a4v39v-accordion-label" aria-expanded="false" aria-selected="false">Como escolher o melhor cartão de crédito? <i class='bx bx-chevron-down'></i></a>
					<div class="accordion-content" data-tab-content="" itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" role="tabpanel" aria-labelledby="a4v39v-accordion-label" aria-hidden="true" id="a4v39v-accordion">
						<div itemprop="text">
							<p>Para escolher o melhor cartão de crédito para você, utilize um comparador de cartões e informe as características que deseja encontrar neste produto financeiro.</p>
							<p>Por isso, em relação ao cartão, considere:</p>
							<ul>
							<li aria-level="1">Cobrança de anuidade;</li>
							<li aria-level="1">Cobertura do cartão: nacional ou internacional;</li>
							<li aria-level="1">Benefícios: programa de pontos, cashback, milhas, descontos em parceiros, etc.;</li>
							<li aria-level="1">Renda mínima compatível;</li>
							<li aria-level="1">Gerenciamento do cartão por aplicativo</li>
							<li aria-level="1">Programas da bandeira do cartão;</li>
							<li aria-level="1">Vantagens proporcionadas pelo banco emissor.</li>
							</ul>
							<p>Depois, considere o seu perfil financeiro, hábitos de compras, hobbies, objetivos e pense que o cartão deve tornar sua experiência de consumo ainda melhor.</p>
							<p>Descubra as vantagens e desvantagens entre as opções e quando estiver confiante de que encontrou o produto ideal para você, clique em “Solicitar Cartão”.</p>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</main>
<?php get_footer(); ?>