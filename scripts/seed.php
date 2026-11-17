<?php

declare(strict_types=1);

defined('ABSPATH') || exit;

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
echo "Catálogo de demonstração preparado.\n";
