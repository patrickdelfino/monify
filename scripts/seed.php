<?php

declare(strict_types=1);

defined('ABSPATH') || exit;

defined('MONIFY_TYPE') || define('MONIFY_TYPE', 'stcode_cartao');
defined('MONIFY_BRAND') || define('MONIFY_BRAND', 'stcode_bandeiras');
defined('MONIFY_BENEFIT') || define('MONIFY_BENEFIT', 'stcode_beneficios');

$cards = [
    ['aurora', 'Aurora', 'visa', 'cashback', 0, 1200, 2000],
    ['brisa', 'Brisa', 'mastercard', 'milhas', 120, 2400, 4500],
    ['cedro', 'Cedro', 'visa', 'milhas', 240, 3500, 6000],
    ['duna', 'Duna', 'elo', 'cashback', 0, 1000, 1500],
    ['estuario', 'Estuário', 'mastercard', 'cashback', 180, 2800, 5000],
    ['farol', 'Farol', 'elo', 'milhas', 360, 4500, 8000],
];
$terms = [
    'visa' => 'Visa', 'mastercard' => 'Mastercard', 'elo' => 'Elo',
    'cashback' => 'Cashback', 'milhas' => 'Milhas',
];

foreach ($cards as [$slug, $name, $brand, $benefit, $fee, $income, $limit]) {
    $existing = get_page_by_path($slug, OBJECT, MONIFY_TYPE);
    if ($existing && !get_post_meta($existing->ID, '_monify_demo_fixture', true)) {
        throw new RuntimeException('Slug em uso por um produto cadastrado fora da demonstração: ' . $slug);
    }
    $post = [
        'post_type' => MONIFY_TYPE,
        'post_status' => 'publish',
        'post_title' => $name,
        'post_name' => $slug,
        'post_content' => 'Ficha fictícia para demonstrar os filtros e a comparação do Monify.',
        'meta_input' => [
            '_monify_demo_fixture' => 1,
            'stcode_anuidade' => $fee,
            'stcode_renda_minima' => $income,
            'stcode_limite_credito' => $limit,
        ],
    ];
    if ($existing) {
        $post['ID'] = $existing->ID;
    }
    $id = wp_insert_post($post, true);
    if (is_wp_error($id)) {
        throw new RuntimeException($id->get_error_message());
    }
    foreach ([MONIFY_BRAND => $brand, MONIFY_BENEFIT => $benefit] as $taxonomy => $term) {
        $entry = get_term_by('slug', $term, $taxonomy);
        if (!$entry) {
            $created = wp_insert_term($terms[$term], $taxonomy, ['slug' => $term]);
            if (is_wp_error($created)) {
                throw new RuntimeException($created->get_error_message());
            }
            $termId = (int) $created['term_id'];
        } else {
            $termId = (int) $entry->term_id;
        }
        $assigned = wp_set_object_terms($id, [$termId], $taxonomy);
        if (is_wp_error($assigned)) {
            throw new RuntimeException($assigned->get_error_message());
        }
    }
}


$menus = get_theme_mod('nav_menu_locations', []);
$menu = wp_get_nav_menu_object('Monify Demo');
if (!$menu) {
    $menu_id = wp_create_nav_menu('Monify Demo');
    if (is_wp_error($menu_id)) {
        throw new RuntimeException($menu_id->get_error_message());
    }
    foreach (['Início' => '/', 'Comparar cartões' => '/comparador-de-cartao-de-credito', 'Blog' => '/blog'] as $label => $route) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => $label,
            'menu-item-url' => home_url($route),
            'menu-item-type' => 'custom',
            'menu-item-status' => 'publish',
        ]);
    }
    $menus['menu-home'] = $menu_id;
    set_theme_mod('nav_menu_locations', $menus);
}
foreach (get_posts(['post_type' => 'stcode_cartao', 'numberposts' => -1, 'meta_key' => '_monify_demo_fixture']) as $card) {
    $route = 'cartoes/' . $card->post_name;
    global $wpdb;
    $wpdb->replace($wpdb->prefix . 'stcode_posts_permalink', [
        'post_id' => $card->ID, 'permalink' => $route, 'last_update' => current_time('mysql'),
    ]);
    update_post_meta($card->ID, 'stcode_notas', '4.5');
    update_post_meta($card->ID, 'stcode_cartao_link', home_url('/' . $route));
}
$cards = json_decode(<<<'MONIFY_DEMO_JSON'
{"aurora": {"benefits": ["Cashback de 0,5% nas compras elegíveis.", "Cartão virtual para compras on-line.", "Gestão de limite e bloqueio pelo aplicativo."], "brand": ["Uso em estabelecimentos da bandeira Visa.", "Pagamento por aproximação."], "pros": ["Anuidade gratuita.", "Renda mínima de R$ 1.200.", "Cashback para compras do dia a dia."], "cons": ["Limite de referência de R$ 2.000.", "Cashback limitado a R$ 30 por mês."]}, "brisa": {"benefits": ["Programa de acúmulo de milhas nas compras elegíveis.", "Cartão virtual para assinaturas.", "Acompanhamento de gastos pelo aplicativo."], "brand": ["Uso em estabelecimentos da bandeira Mastercard.", "Pagamento por aproximação."], "pros": ["Limite de referência de R$ 4.500.", "Acúmulo de milhas nas compras."], "cons": ["Anuidade de R$ 120.", "Renda mínima de R$ 2.400.", "Milhas sujeitas a validade no programa fictício."]}, "cedro": {"benefits": ["Acúmulo de milhas com bônus em categorias selecionadas.", "Cartão adicional com controle de gastos.", "Avisos de compras em tempo real."], "brand": ["Uso em estabelecimentos da bandeira Visa.", "Pagamento por aproximação."], "pros": ["Limite de referência de R$ 6.000.", "Bônus de milhas em categorias selecionadas.", "Controle de gastos do cartão adicional."], "cons": ["Anuidade de R$ 240.", "Renda mínima de R$ 3.500.", "Bônus restrito a categorias elegíveis."]}, "duna": {"benefits": ["Cashback de 0,3% nas compras elegíveis.", "Cartão virtual com bloqueio pelo aplicativo.", "Notificações de compras."], "brand": ["Uso em estabelecimentos da bandeira Elo.", "Pagamento por aproximação."], "pros": ["Anuidade gratuita.", "Renda mínima de R$ 1.000.", "Cashback nas compras elegíveis."], "cons": ["Limite de referência de R$ 1.500.", "Cashback limitado a R$ 20 por mês."]}, "estuario": {"benefits": ["Cashback de 0,8% nas compras elegíveis.", "Cartão adicional com limites configuráveis.", "Resumo de gastos por categoria."], "brand": ["Uso em estabelecimentos da bandeira Mastercard.", "Pagamento por aproximação."], "pros": ["Limite de referência de R$ 5.000.", "Cashback de 0,8% nas compras elegíveis.", "Controle do cartão adicional."], "cons": ["Anuidade de R$ 180.", "Renda mínima de R$ 2.800.", "Cashback limitado a R$ 60 por mês."]}, "farol": {"benefits": ["Acúmulo de milhas nas compras elegíveis.", "Cartões adicionais com controle individual.", "Relatório de gastos por categoria."], "brand": ["Uso em estabelecimentos da bandeira Elo.", "Pagamento por aproximação."], "pros": ["Maior limite do catálogo fictício, de R$ 8.000.", "Acúmulo de milhas nas compras.", "Controle individual de cartões adicionais."], "cons": ["Anuidade de R$ 360.", "Renda mínima de R$ 4.500.", "Milhas sujeitas a validade no programa fictício."]}}
MONIFY_DEMO_JSON
, true, 512, JSON_THROW_ON_ERROR);
foreach ($cards as $slug => $data) {
    $card = get_page_by_path($slug, OBJECT, 'stcode_cartao');
    if (!$card || !get_post_meta($card->ID, '_monify_demo_fixture', true)) {
        throw new RuntimeException('Cartão fictício não encontrado: ' . $slug);
    }
    update_post_meta($card->ID, 'stcode_beneficios_detalhados', implode("\n", $data['benefits']));
    update_post_meta($card->ID, 'stcode_bandeira_detalhado', implode("\n", $data['brand']));
    foreach (['pros' => 'pros', 'contras' => 'cons'] as $taxonomy => $key) {
        $assigned = wp_set_object_terms($card->ID, $data[$key], $taxonomy);
        if (is_wp_error($assigned)) {
            throw new RuntimeException($assigned->get_error_message());
        }
    }
}
echo count($cards) . " cartões fictícios atualizados.\n";
