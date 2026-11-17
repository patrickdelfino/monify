<?php get_header();
global $postID;
$offer = esc_url(get_post_meta($postID, 'stcode_cartao_link', true));
$can_apply = $offer !== '' && untrailingslashit($offer) !== untrailingslashit(get_permalink($postID));
?>
<div class="container-section pd-fix monify-card-single">
    <div class="box-card">
        <div class="row-section row-details">
            <div class="grid-x grid-padding-x">
                <div class="cell small-6 medium-6 large-6 border-right">
                    <div class="cartao__details">
                        <div class="list__img"><img width="140" height="90" src="<?php echo get_solo_image($postID); ?>" alt="<?php echo get_the_title($postID); ?>" title="<?php echo get_the_title($postID); ?>"></div>
                        <div class="textos">
                            <?php if ($can_apply): ?><a href="<?php echo $offer; ?>" target="_blank" rel="noopener">Peça já seu cartão!</a><?php else: ?><a href="<?php echo esc_url(home_url('/comparador-de-cartao-de-credito')); ?>">Compare este cartão</a><?php endif; ?>
                            <h1><?php echo get_the_title($postID); ?></h1>
                        </div>
                    </div>
                </div>
                <div class="cell small-6 medium-6 large-6 display-flex">
                    <div class="cartao__itens">
                        <div class="wrap__card--row">
                            <div><b>Anuidade</b> <?php echo get_post_meta($postID,'stcode_anuidade',true); ?></div>
                        </div>
                        <div class="wrap__card--row">
                            <div><b>Limite de crédito</b><div> <?php echo get_post_meta($postID,'stcode_limite_credito',true); ?></div></div>
                        </div>
                        <div class="wrap__card--row">
                            <div><b>Benefícios</b> <span> <?php echo get_terms_list_attribute( $postID, 'stcode_beneficios', 'name', 3); ?></span></div>
                        </div>
                        <div class="wrap__card--row">
                            <div><b>Renda mínima</b> <?php echo get_post_meta($postID,'stcode_renda_minima',true); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row-section row-contras">
        <div class="grid-x grid-d grid-padding-x">
            <div class="small-6 medium-6 large-5 box-card">
                <h3 class="title_box">Prós</h3>
                <?php
                $pros = explode(",",get_terms_list_attribute( $postID, 'pros', 'name', 0));
                if ($pros) {
                    foreach ($pros as $pro) {
                        echo "<div class=\"list__row\">
                        <div><i class=\"bx bx-check\"></i></div>
                        <div class=\"list__info\">$pro</div>
                        </div>";
                    }
                }
                ?>
            </div>
            <div class="small-6 medium-6 large-5 box-card">
                <h3 class="title_box">Contras</h3>
                <?php
                $contras = explode(",",get_terms_list_attribute( $postID, 'contras', 'name', 0));
                if ($contras) {
                    foreach ($contras as $contra) {
                        echo "<div class=\"list__row\">
                        <div><i class=\"bx bx-x\"></i></div>
                        <div class=\"list__info\">$contra</div>
                        </div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="box-card">
        <h3 class="title_box">Benefícios do cartão</h3>
        <?php $beneficios = explode("\n",get_post_meta($postID,'stcode_beneficios_detalhados',true));
        if ($beneficios) {
            foreach ($beneficios as $beneficio) {
                echo '<p>'.html_entity_decode($beneficio).'</p>';
            }
        } ?>
    </div>
    <div id="main-extra-cards" class="cell small-12 medium-12 large-12">
        <div class="faq__summary faq__row" style="background-color: transparent;box-shadow: 0 0 0;padding: 0;">
            <span class="faq__title">Mais benefícios do seu <?php echo get_the_title($postID); ?></span>
            <ul class="accordion faq__summary--content" role="tablist" style="background-color: transparent;">
                <?php echo generate_accordion_html(get_post_meta($postID,'stcode_tabs',true)); ?>
            </ul>
        </div>
    </div>
    <div class="display-flex">
        <?php if ($can_apply): ?>
            <a class="cta button expanded" href="<?php echo $offer; ?>" target="_blank" rel="noopener">Solicitar cartão <i class="bx bx-right-arrow-alt" aria-hidden="true"></i></a>
        <?php else: ?>
            <a class="cta button expanded" href="<?php echo esc_url(add_query_arg('primeiro', get_post_field('post_name', $postID), home_url('/comparador-de-cartao-de-credito/comparar/'))); ?>">Comparar com outro cartão <i class="bx bx-right-arrow-alt" aria-hidden="true"></i></a>
        <?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>