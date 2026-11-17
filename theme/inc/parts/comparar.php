<?php
$catalog_url = home_url('/comparador-de-cartao-de-credito');
$compare_url = trailingslashit($catalog_url) . 'comparar/';
$available = get_posts([
    'post_type' => 'stcode_cartao',
    'post_status' => 'publish',
    'numberposts' => -1,
    'orderby' => 'title',
    'order' => 'ASC',
]);
$by_slug = array_column($available, null, 'post_name');
$input = static function ($key) {
    return isset($_GET[$key]) && is_string($_GET[$key]) ? trim(wp_unslash($_GET[$key])) : '';
};
$slugs = array_key_exists('primeiro', $_GET) || array_key_exists('segundo', $_GET)
    ? [$input('primeiro'), $input('segundo')]
    : explode('X', $input('cartoes'));
$valid = count($slugs) === 2 && $slugs[0] !== $slugs[1]
    && isset($by_slug[$slugs[0]], $by_slug[$slugs[1]]);
$cards = $valid ? [$by_slug[$slugs[0]], $by_slug[$slugs[1]]] : [];

$money = static function ($id, $key) {
    $value = trim((string) get_post_meta($id, $key, true));
    if ($value === '') {
        return 'Não informado';
    }
    return is_numeric($value) ? 'R$ ' . number_format((float) $value, 2, ',', '.') : $value;
};
$terms = static function ($id, $taxonomy) {
    $values = wp_get_post_terms($id, $taxonomy, ['fields' => 'names']);
    return is_wp_error($values) ? [] : $values;
};
$details = static function ($id, $key, $fallback) use ($terms) {
    $lines = preg_split('/\R/u', (string) get_post_meta($id, $key, true)) ?: [];
    $lines = array_values(array_filter(array_map('trim', $lines), 'strlen'));
    return $lines ?: $terms($id, $fallback);
};


// Compara somente valores numéricos explícitos na mesma unidade.
$advantages = [];
if ($valid) {
    $criteria = [
        'Anuidade' => ['key' => 'stcode_anuidade', 'direction' => 'min', 'label' => 'Menor anuidade'],
        'Limite de crédito' => ['key' => 'stcode_limite_credito', 'direction' => 'max', 'label' => 'Maior limite'],
        'Renda mínima' => ['key' => 'stcode_renda_minima', 'direction' => 'min', 'label' => 'Menor renda exigida'],
    ];
    $numeric_value = static function ($id, $key) {
        $raw = trim((string) get_post_meta($id, $key, true));
        if ($raw === '' || !is_numeric($raw) || !is_finite((float) $raw) || (float) $raw < 0) {
            return null;
        }
        return round((float) $raw, 2);
    };
    foreach ($criteria as $label => $criterion) {
        $first = $numeric_value($cards[0]->ID, $criterion['key']);
        $second = $numeric_value($cards[1]->ID, $criterion['key']);
        if ($first === null || $second === null) {
            continue;
        }
        if ($first === $second) {
            $advantages[$label] = [0 => 'Mesma condição', 1 => 'Mesma condição'];
            continue;
        }
        $best = $criterion['direction'] === 'min' ? min($first, $second) : max($first, $second);
        $side = $first === $best ? 0 : 1;
        $advantages[$label] = [$side => $criterion['label']];
    }
}


if (!$valid) {
?>
get_header();
?>
<a class="prev-tool" href="<?php echo esc_url($catalog_url); ?>"><i class="bx bx-chevron-left" aria-hidden="true"></i> Retornar à lista de cartões</a>
<main class="container-section pd-fix monify-comparison">
    <div class="h__headline h__headline--fix text-center">
        <h1>Compare os cartões de crédito</h1>
        <p>Selecione dois cartões diferentes para comparar as condições.</p>
        <?php if ($valid): ?><p class="monify-advantage-guide">Os destaques indicam menor anuidade, maior limite e menor renda exigida entre os valores informados.</p><?php endif; ?>
    </div>
    <?php if (!$valid && (isset($_GET['cartoes']) || isset($_GET['primeiro']) || isset($_GET['segundo']))): ?>
        <p class="monify-comparison-message" role="status">Selecione dois cartões distintos e disponíveis.</p>
    <?php endif; ?>
    <?php if (count($available) < 2): ?>
        <p class="monify-comparison-message">São necessários pelo menos dois cartões disponíveis.</p>
    <?php else: ?>
        <div class="group-section">
            <form class="comparar-page" method="get" action="<?php echo esc_url($compare_url); ?>" data-monify-pair>
                <div class="monify-pair">
                <?php foreach (['primeiro', 'segundo'] as $side => $name): ?>
                    <?php $card = $cards[$side] ?? null; ?>
                    <div class="monify-pair-card">
                        <?php if ($card): ?>
                            <?php $image = esc_url(get_solo_image($card->ID)) ?: esc_url(STCODE_URI . '/assets/vetors/credit.svg'); ?>
                            <div class="list__card">
                                <div class="list__img"><img width="140" height="90" src="<?php echo $image; ?>" alt=""></div>
                                <div class="item__headline"><h3><?php echo esc_html(get_the_title($card)); ?></h3></div>
                            </div>
                        <?php endif; ?>
                        <label>
                            <span><?php echo $side === 0 ? 'Primeiro cartão' : 'Segundo cartão'; ?></span>
                            <select name="<?php echo esc_attr($name); ?>" required>
                                <option value="">Selecione um cartão</option>
                                <?php foreach ($available as $option): ?>
                                    <option value="<?php echo esc_attr($option->post_name); ?>" <?php selected($slugs[$side] ?? '', $option->post_name); ?>><?php echo esc_html(get_the_title($option)); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <?php if ($card && ($offer = get_post_meta($card->ID, 'stcode_cartao_link', true))): ?>
                            <div class="list__cta text-center"><a class="button expanded" href="<?php echo esc_url($offer); ?>" target="_blank" rel="noopener">Solicitar cartão <i class="bx bx-check-shield icon-button" aria-hidden="true"></i></a></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                </div>
                <button class="button monify-update-comparison" type="submit"><?php echo $valid ? 'Atualizar comparação' : 'Comparar cartões'; ?></button>
            </form>
            <?php if ($valid): ?>
                <?php
                $rows = [
                    'Anuidade' => static function ($id) use ($money) { return [$money($id, 'stcode_anuidade')]; },
                    'Limite de crédito' => static function ($id) use ($money) { return [$money($id, 'stcode_limite_credito')]; },
                    'Renda mínima' => static function ($id) use ($money) { return [$money($id, 'stcode_renda_minima')]; },
                    'Benefícios do cartão' => static function ($id) use ($details) { return $details($id, 'stcode_beneficios_detalhados', 'stcode_beneficios'); },
                    'Bandeira' => static function ($id) use ($details) { return $details($id, 'stcode_bandeira_detalhado', 'stcode_bandeiras'); },
                    'Prós' => static function ($id) use ($terms) { return $terms($id, 'pros'); },
                    'Contras' => static function ($id) use ($terms) { return $terms($id, 'contras'); },
                ];
                ?>
                <table class="monify-comparison-table">
                    <caption class="screen-reader-text">Condições dos cartões selecionados</caption>
                    <thead><tr><th scope="col">Condição</th>
                    <?php foreach ($cards as $card): ?><th scope="col"><?php echo esc_html(get_the_title($card)); ?></th><?php endforeach; ?>
                    </tr></thead>
                    <tbody>
                    <?php foreach ($rows as $label => $get_values): ?>
                        <tr>
                            <th class="row-section__title" scope="row"><?php echo esc_html($label); ?></th>
                            <?php foreach ($cards as $side => $card): ?>
                                <?php
                                $values = $get_values($card->ID);
                                $advantage = $advantages[$label][$side] ?? '';
                                ?>
                                <td<?php if ($advantage !== ''): ?> class="monify-condition-advantage"<?php endif; ?>>
                                    <?php if ($advantage !== ''): ?><span class="monify-advantage-badge"><?php echo esc_html($advantage); ?></span><?php endif; ?>
                                    <?php if (!$values): ?>Não informado
                                    <?php elseif (count($values) === 1): echo esc_html(wp_strip_all_tags(html_entity_decode($values[0], ENT_QUOTES, 'UTF-8')));
                                    else: ?>
                                        <ul><?php foreach ($values as $value): ?><li><?php echo esc_html(wp_strip_all_tags(html_entity_decode($value, ENT_QUOTES, 'UTF-8'))); ?></li><?php endforeach; ?></ul>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>
<?php get_footer(); ?>

<?php
return;
}

$render_items = static function ($items, $icon) {
    if (!$items) {
        echo '<p class="monify-empty-details">Não informado.</p>';
        return;
    }
    echo '<ul class="monify-editorial-items">';
    foreach ($items as $item) {
        echo '<li><i class="' . esc_attr($icon) . '" aria-hidden="true"></i><span>'
            . esc_html(wp_strip_all_tags(html_entity_decode($item, ENT_QUOTES, 'UTF-8'))) . '</span></li>';
    }
    echo '</ul>';
};
$cartao1 = $cards[0]->ID;
$cartao2 = $cards[1]->ID;
$show_advantage = static function ($label, $side) use ($advantages) {
    $advantage = $advantages[$label][$side] ?? '';
    if ($advantage !== '') {
        echo '<span class="monify-advantage-badge">' . esc_html($advantage) . '</span>';
    }
};
get_header();
?>
<a class="prev-tool" href="<?php echo get_home_url(); ?>/comparador-de-cartao-de-credito"><i class='bx bx-chevron-left'></i> retornar à lista de cartões</a>
<div class="container-section pd-fix monify-comparison monify-original-comparison">
	<div class="h__headline h__headline--fix  text-center">
		<h1>Compare os cartões de crédito</h1>
		<p>Selecione abaixo os cartões que você deseja comparar</p>
	</div>
	<form id="monify-change-pair" action="<?php echo esc_url($compare_url); ?>" method="get"></form>
    <?php if (get_post_meta($cartao1, '_monify_demo_fixture', true) && get_post_meta($cartao2, '_monify_demo_fixture', true)): ?>
        <p class="monify-comparison-message monify-demo-note">Cartões fictícios para demonstração.</p>
    <?php endif; ?>
    <div class="monify-pair-update">
        <button class="button" form="monify-change-pair" type="submit">Atualizar comparação <i class="bx bx-refresh" aria-hidden="true"></i></button>
        <p data-monify-pair-status role="status" aria-live="polite"></p>
    </div>
    <div class="row-header card-sticky">
		<div class="grid-x grid-padding-x">
			<div class="group-section">
				<div class="comparar-page">
					<div class="grid-x grid-padding-x">
						<div class="cell small-6 medium-6 large-6 border-right">
							<div class="sections sections-left">
								<div class="list">
									<div class="list__card">
										<div class="list__img"><img width="140" height="90" src="<?php echo esc_url(get_solo_image($cartao1)) ?: esc_url(STCODE_URI . '/assets/vetors/credit.svg'); ?>" alt="<?php echo esc_html(get_the_title($cartao1)); ?>" title="<?php echo esc_html(get_the_title($cartao1)); ?>"></div>
										<div class="change_card">
											<div class="monify-original-card-switch">
        <label><span class="screen-reader-text">Primeiro cartão</span>
        <select form="monify-change-pair" name="primeiro" required>
            <?php foreach ($available as $option): ?>
                <option value="<?php echo esc_attr($option->post_name); ?>" <?php selected($slugs[0], $option->post_name); ?>><?php echo esc_html(get_the_title($option)); ?></option>
            <?php endforeach; ?>
        </select></label>
    </div>
											<div class="list__title">
												<div class="item__headline">
													<h3 title="<?php echo esc_html(get_the_title($cartao1)); ?>"><?php echo esc_html(get_the_title($cartao1)); ?></h3>
												</div>
											</div>
										</div>
									</div>
									<div class="list__cta text-center">
										<a class="button expanded" target="_blank" data-offer-context="offer-card" href="<?php echo esc_url(get_post_meta($cartao1,'stcode_cartao_link',true)); ?>">Solicitar Cartão <i class="bx bx-check-shield icon-button"></i></a>
										<div class="color-gray"><small><i class="bx bx-check"></i> URL Verificada</small></div>
									</div>
			                    </div>
			                </div>
			            </div>
			            <div class="cell small-6 medium-6 large-6">
			            	<div class="sections sections-right">
			            		<div class="list">
									<div class="list__card">
										<div class="list__img"><img width="140" height="90" src="<?php echo esc_url(get_solo_image($cartao2)) ?: esc_url(STCODE_URI . '/assets/vetors/credit.svg'); ?>" alt="<?php echo esc_html(get_the_title($cartao2)); ?>" title="<?php echo esc_html(get_the_title($cartao2)); ?>"></div>
										<div class="change_card">
											<div class="monify-original-card-switch">
        <label><span class="screen-reader-text">Segundo cartão</span>
        <select form="monify-change-pair" name="segundo" required>
            <?php foreach ($available as $option): ?>
                <option value="<?php echo esc_attr($option->post_name); ?>" <?php selected($slugs[1], $option->post_name); ?>><?php echo esc_html(get_the_title($option)); ?></option>
            <?php endforeach; ?>
        </select></label>
    </div>
											<div class="list__title">
												<div class="item__headline">
													<h3 title="<?php echo esc_html(get_the_title($cartao2)); ?>"><?php echo esc_html(get_the_title($cartao2)); ?></h3>
												</div>
											</div>
										</div>
									</div>
									<div class="list__cta text-center">
										<a class="button expanded" target="_blank" data-offer-context="offer-card" href="<?php echo esc_url(get_post_meta($cartao2,'stcode_cartao_link',true)); ?>">Solicitar Cartão <i class="bx bx-check-shield icon-button"></i></a>
										<div class="color-gray"><small><i class="bx bx-check"></i> URL Verificada</small></div>
									</div>
			                    </div>
			                </div>
			            </div>
			        </div>
			        <div class="row-section row-details">
						<div class="grid-x grid-padding-x">
							<div class="cell small-6 medium-6 large-6 border-right">
			                    <div class="list__details text-center">
			                    	<div class="wrap__card--row">
			                    		<i class="bx bx-calendar-event icon-review"></i>
			                    		<div><b>Anuidade</b> <?php echo esc_html($money($cartao1, 'stcode_anuidade')); $show_advantage('Anuidade', 0); ?></div>
			                    	</div>
			                    	<div class="wrap__card--row">
			                    		<i class="bx bxs-objects-vertical-bottom icon-review"></i>
			                    		<div><b>Limite de crédito</b><div> <?php echo esc_html($money($cartao1, 'stcode_limite_credito')); $show_advantage('Limite de crédito', 0); ?></div></div>
			                    	</div>
			                    	<div class="wrap__card--row">
			                    		<i class="bx bxl-meta icon-review"></i>
			                    		<div><b>Benefícios</b> <span> <?php echo get_terms_list_attribute( $cartao1, 'stcode_beneficios', 'name', 3); ?></span></div>
			                    	</div>
			                    	<div class="wrap__card--row">
			                    		<i class="bx bx-dollar-circle icon-review"></i>
			                    		<div><b>Renda mínima</b> <?php echo esc_html($money($cartao1, 'stcode_renda_minima')); $show_advantage('Renda mínima', 0); ?></div>
			                    	</div>
			                    </div>
			            	</div>
			            	<div class="cell small-6 medium-6 large-6">
			            		<div class="list__details text-center">
			                    	<div class="wrap__card--row">
			                    		<i class="bx bx-calendar-event icon-review"></i>
			                    		<div><b>Anuidade</b> <?php echo esc_html($money($cartao2, 'stcode_anuidade')); $show_advantage('Anuidade', 1); ?></div>
			                    	</div>
			                    	<div class="wrap__card--row">
			                    		<i class="bx bxs-objects-vertical-bottom icon-review"></i>
			                    		<div><b>Limite de crédito</b><div> <?php echo esc_html($money($cartao2, 'stcode_limite_credito')); $show_advantage('Limite de crédito', 1); ?></div></div>
			                    	</div>
			                    	<div class="wrap__card--row">
			                    		<i class="bx bxl-meta icon-review"></i>
			                    		<div><b>Benefícios</b> <span> <?php echo get_terms_list_attribute( $cartao2, 'stcode_beneficios', 'name', 3); ?></span></div>
			                    	</div>
			                    	<div class="wrap__card--row">
			                    		<i class="bx bx-dollar-circle icon-review"></i>
			                    		<div><b>Renda mínima</b> <?php echo esc_html($money($cartao2, 'stcode_renda_minima')); $show_advantage('Renda mínima', 1); ?></div>
			                    	</div>
			                    </div>
			                </div>
			            </div>
	                </div>
	                <div class="row-section row-anuidade first">
						<div class="grid-x grid-padding-x">
							<div class="cell small-12 medium-12 large-12"><span class="row-section__title">Anuidade</span></div>
							<div class="cell small-6 medium-6 large-6 border-right">
								<div class="sections sections-left">
									<div class="row-list">
										<div class="list__info"><?php echo esc_html($money($cartao1, 'stcode_anuidade')); $show_advantage('Anuidade', 0); ?></div>
									</div>
								</div>
							</div>
							<div class="cell small-6 medium-6 large-6">
								<div class="sections sections-right">
									<div class="row-list">
                                        <div class="list__info"><?php echo esc_html($money($cartao2, 'stcode_anuidade')); $show_advantage('Anuidade', 1); ?></div>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
					<div class="row-section row-beneficios">
						<div class="grid-x grid-padding-x">
							<div class="cell small-12 medium-12 large-12"><span class="row-section__title">Benefícios do cartão</span></div>
							<div class="cell small-6 medium-6 large-6 border-right">
								<div class="sections sections-left">
									<div class="row-list">
										<div class="list__info">
											<?php $render_items($details($cartao1, 'stcode_beneficios_detalhados', 'stcode_beneficios'), 'bx bx-check'); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="cell small-6 medium-6 large-6">
								<div class="sections sections-right">
									<div class="row-list">
                                        <div class="list__info">
                                        	<?php $render_items($details($cartao2, 'stcode_beneficios_detalhados', 'stcode_beneficios'), 'bx bx-check'); ?>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
					<div class="row-section row-bandeiras">
						<div class="grid-x grid-padding-x">
							<div class="cell small-12 medium-12 large-12"><span class="row-section__title">Benefícios da bandeira</span></div>
							<div class="cell small-6 medium-6 large-6 border-right">
								<div class="sections sections-left">
									<div class="row-list">
										<div class="list__info">
											<?php $render_items($details($cartao1, 'stcode_bandeira_detalhado', 'stcode_bandeiras'), 'bx bx-check'); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="cell small-6 medium-6 large-6">
								<div class="sections sections-right">
									<div class="row-list">
                                        <div class="list__info">
                                        	<?php $render_items($details($cartao2, 'stcode_bandeira_detalhado', 'stcode_bandeiras'), 'bx bx-check'); ?>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
					<div class="row-section row-pros">
						<div class="grid-x grid-padding-x">
							<div class="cell small-12 medium-12 large-12"><span class="row-section__title">Prós</span></div>
							<div class="cell small-6 medium-6 large-6 border-right">
								<div class="sections sections-left">
									<div class="row-list">
										<div class="list__info">
											<?php $render_items($terms($cartao1, 'pros'), 'bx bx-check'); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="cell small-6 medium-6 large-6">
								<div class="sections sections-right">
									<div class="row-list">
                                        <div class="list__info">
                                        	<?php $render_items($terms($cartao2, 'pros'), 'bx bx-check'); ?>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
					<div class="row-section row-contras">
						<div class="grid-x grid-padding-x">
							<div class="cell small-12 medium-12 large-12"><span class="row-section__title">Contras</span></div>
							<div class="cell small-6 medium-6 large-6 border-right">
								<div class="sections sections-left">
									<div class="row-list">
										<div class="list__info">
											<?php $render_items($terms($cartao1, 'contras'), 'bx bx-x'); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="cell small-6 medium-6 large-6">
								<div class="sections sections-right">
									<div class="row-list">
                                        <div class="list__info">
                                        	<?php $render_items($terms($cartao2, 'contras'), 'bx bx-x'); ?>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
	            </div>
	        </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>