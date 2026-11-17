<?php

declare(strict_types=1);

defined('ABSPATH') || exit;

const MONIFY_TYPE = 'stcode_cartao';
const MONIFY_BRAND = 'stcode_bandeiras';
const MONIFY_BENEFIT = 'stcode_beneficios';

add_action('init', static function (): void {
    register_post_type(MONIFY_TYPE, [
        'label' => 'Cartões',
        'public' => true,
        'has_archive' => false,
        'show_in_rest' => true,
        'supports' => ['title', 'editor'],
        'rewrite' => false,
        'menu_icon' => 'dashicons-money-alt',
    ]);
    register_taxonomy(MONIFY_BRAND, MONIFY_TYPE, ['label' => 'Bandeiras', 'public' => true, 'rewrite' => false]);
    register_taxonomy(MONIFY_BENEFIT, MONIFY_TYPE, ['label' => 'Benefícios', 'public' => true, 'rewrite' => false]);
});

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_style('monify-demo', get_stylesheet_uri(), [], '1.0.0');
});

function monify_fields(): array
{
    return [
        'stcode_anuidade' => 'Anuidade em reais',
        'stcode_renda_minima' => 'Renda mínima em reais',
        'stcode_limite_credito' => 'Limite em reais',
    ];
}

add_action('add_meta_boxes_' . MONIFY_TYPE, static function (): void {
    add_meta_box('monify-values', 'Condições do cartão', static function (WP_Post $post): void {
        wp_nonce_field('monify-save-card', 'monify_nonce');
        foreach (monify_fields() as $key => $label) {
            printf(
                '<p><label>%s <input name="monify_values[%s]" type="number" min="0" max="10000000" step="1" value="%s" required></label></p>',
                esc_html($label),
                esc_attr($key),
                esc_attr(get_post_meta($post->ID, $key, true))
            );
        }
    }, MONIFY_TYPE);
});

add_action('save_post_' . MONIFY_TYPE, static function (int $id): void {
    $nonce = monify_input($_POST, 'monify_nonce');
    if (wp_is_post_revision($id) || wp_is_post_autosave($id)
        || !current_user_can('edit_post', $id) || !wp_verify_nonce($nonce, 'monify-save-card')) {
        return;
    }
    $values = $_POST['monify_values'] ?? [];
    if (!is_array($values)) {
        return;
    }
    foreach (monify_fields() as $key => $unused) {
        $amount = monify_amount(monify_input($values, $key));
        if ($amount !== null) {
            update_post_meta($id, $key, $amount);
        }
    }
});

function monify_input(array $input, string $name): string
{
    return isset($input[$name]) && is_string($input[$name])
        ? sanitize_text_field(wp_unslash($input[$name]))
        : '';
}

function monify_amount(string $value): ?int
{
    $number = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 10000000]]);
    return $number === false ? null : $number;
}

function monify_card(int $id): array
{
    $data = ['name' => get_the_title($id)];
    foreach (monify_fields() as $key => $label) {
        $value = get_post_meta($id, $key, true);
        $data[$key] = $value === '' ? 'Não informado' : 'R$ ' . number_format((int) $value, 2, ',', '.');
    }
    $names = wp_get_post_terms($id, MONIFY_BENEFIT, ['fields' => 'names']);
    $data['benefits'] = !is_wp_error($names) && $names ? implode(', ', $names) : 'Não informado';
    return $data;
}

function monify_catalog(array $filters): WP_Query
{
    $args = [
        'post_type' => MONIFY_TYPE,
        'post_status' => 'publish',
        'posts_per_page' => 4,
        'paged' => $filters['page'],
        'orderby' => ['title' => 'ASC', 'ID' => 'ASC'],
        's' => $filters['q'],
    ];
    foreach (['brand' => MONIFY_BRAND, 'benefit' => MONIFY_BENEFIT] as $key => $taxonomy) {
        if ($filters[$key] !== '') {
            $args['tax_query'][] = ['taxonomy' => $taxonomy, 'field' => 'slug', 'terms' => $filters[$key]];
        }
    }
    if ($filters['income'] !== null) {
        $args['meta_query'][] = [
            'key' => 'stcode_renda_minima', 'value' => $filters['income'], 'compare' => '<=', 'type' => 'NUMERIC',
        ];
    }
    return new WP_Query($args);
}

function monify_selection($raw): array
{
    if (!is_array($raw) || count($raw) !== 2) {
        return [];
    }
    $posts = [];
    foreach ($raw as $value) {
        if (!is_string($value) || !ctype_digit($value) || (int) $value <= 0) {
            return [];
        }
        $post = get_post((int) $value);
        if (!$post || $post->post_type !== MONIFY_TYPE || $post->post_status !== 'publish' || isset($posts[$post->ID])) {
            return [];
        }
        $posts[$post->ID] = monify_card($post->ID);
    }
    return array_values($posts);
}
