<?php

declare(strict_types=1);

defined('ABSPATH') || exit;

$catalogUrl = home_url('/');
$selection = $_GET['cartoes'] ?? null;
$comparison = monify_selection($selection);
$filters = [
    'q' => monify_input($_GET, 'q'),
    'brand' => sanitize_title(monify_input($_GET, 'brand')),
    'benefit' => sanitize_title(monify_input($_GET, 'benefit')),
    'income' => monify_amount(monify_input($_GET, 'income')),
    'page' => max(1, min(1000, (int) monify_input($_GET, 'pagina'))),
];
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monify | Catálogo de cartões</title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header"><a href="<?php echo esc_url($catalogUrl); ?>">Monify</a><span>Demonstração · dados fictícios</span></header>
<main>
<?php if ($selection !== null && count($comparison) === 2): ?>
    <p><a href="<?php echo esc_url($catalogUrl); ?>">Voltar ao catálogo</a></p>
    <h1>Comparação de cartões</h1>
    <table>
        <thead><tr><th scope="col">Condição</th>
            <?php foreach ($comparison as $card): ?><th scope="col"><?php echo esc_html($card['name']); ?></th><?php endforeach; ?>
        </tr></thead>
        <tbody>
        <?php foreach (monify_fields() + ['benefits' => 'Benefícios'] as $field => $label): ?>
            <tr><th scope="row"><?php echo esc_html($label); ?></th>
                <?php foreach ($comparison as $card): ?><td><?php echo esc_html($card[$field]); ?></td><?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif (is_singular(MONIFY_TYPE)): ?>
    <?php while (have_posts()): the_post(); $card = monify_card(get_the_ID()); ?>
        <p><a href="<?php echo esc_url($catalogUrl); ?>">Voltar ao catálogo</a></p>
        <h1><?php echo esc_html($card['name']); ?></h1>
        <?php the_content(); ?>
        <dl><?php foreach (monify_fields() + ['benefits' => 'Benefícios'] as $field => $label): ?>
            <div><dt><?php echo esc_html($label); ?></dt><dd><?php echo esc_html($card[$field]); ?></dd></div>
        <?php endforeach; ?></dl>
    <?php endwhile; ?>
<?php else: ?>
    <h1>Catálogo de cartões</h1>
    <?php if ($selection !== null): ?><p class="notice" role="alert">Selecione dois cartões distintos e publicados para comparar.</p><?php endif; ?>
    <form class="filters" method="get" action="<?php echo esc_url($catalogUrl); ?>">
        <label>Buscar <input name="q" type="search" value="<?php echo esc_attr($filters['q']); ?>"></label>
        <?php foreach (['brand' => ['Bandeira', MONIFY_BRAND], 'benefit' => ['Benefício', MONIFY_BENEFIT]] as $key => [$label, $taxonomy]): ?>
            <label><?php echo esc_html($label); ?><select name="<?php echo esc_attr($key); ?>"><option value="">Todos</option>
            <?php $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => true]); ?>
            <?php foreach (is_wp_error($terms) ? [] : $terms as $term): ?>
                <option value="<?php echo esc_attr($term->slug); ?>" <?php selected($filters[$key], $term->slug); ?>><?php echo esc_html($term->name); ?></option>
            <?php endforeach; ?>
            </select></label>
        <?php endforeach; ?>
        <label>Minha renda mensal <input name="income" type="number" min="0" max="10000000" step="1" value="<?php echo esc_attr($filters['income'] ?? ''); ?>"></label>
        <button>Filtrar</button>
    </form>
    <?php $catalog = monify_catalog($filters); ?>
    <?php if ($catalog->have_posts()): ?>
        <form class="compare" method="get" action="<?php echo esc_url($catalogUrl); ?>">
        <fieldset>
            <legend>Selecione dois cartões</legend>
            <div class="cards">
            <?php while ($catalog->have_posts()): $catalog->the_post(); $card = monify_card(get_the_ID()); ?>
                <article>
                    <h2><a href="<?php the_permalink(); ?>"><?php echo esc_html($card['name']); ?></a></h2>
                    <dl><?php foreach (monify_fields() + ['benefits' => 'Benefícios'] as $field => $label): ?>
                        <div><dt><?php echo esc_html($label); ?></dt><dd><?php echo esc_html($card[$field]); ?></dd></div>
                    <?php endforeach; ?></dl>
                    <label class="option"><input type="checkbox" name="cartoes[]" value="<?php echo esc_attr(get_the_ID()); ?>"> Comparar <?php echo esc_html($card['name']); ?></label>
                </article>
            <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <button>Comparar cartões</button>
        </fieldset>
        </form>
        <?php if ($catalog->max_num_pages > 1): ?>
            <nav class="pages" aria-label="Páginas do catálogo">
            <?php
            $query = array_filter([
                'q' => $filters['q'], 'brand' => $filters['brand'], 'benefit' => $filters['benefit'], 'income' => $filters['income'],
            ], static fn ($value): bool => $value !== null && $value !== '');
            echo wp_kses_post(paginate_links([
                'base' => str_replace('pagina=__monify_page__', 'pagina=%#%', add_query_arg($query + ['pagina' => '__monify_page__'], $catalogUrl)),
                'format' => '', 'current' => $filters['page'], 'total' => $catalog->max_num_pages,
                'prev_text' => 'Anterior', 'next_text' => 'Próxima', 'add_args' => [],
            ]));
            ?>
            </nav>
        <?php endif; ?>
    <?php else: ?>
        <p>Nenhum cartão corresponde aos filtros selecionados.</p>
    <?php endif; ?>
<?php endif; ?>
</main>
<?php wp_footer(); ?>
</body>
</html>
