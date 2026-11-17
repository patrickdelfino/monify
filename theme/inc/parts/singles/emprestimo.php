<?php get_header(); 
global $postID;
$ceb = get_post_meta($postID, 'stcode_artigo_tipo', true);
$cartao_name = stcode_artigoname($ceb);
$author_id = get_post_field ('post_author', $postID); ?>
<div class="container single">
    <div class="row">
        <div class="column column-12 column-8">
            <?php
            if (have_posts()) { while (have_posts() ) { the_post(); ?>
            <article class="mb-48 mb-64">
                <div class="meta-header"><a href="<?php echo home_url('/'.$ceb.'/'); ?>" rel="category tag"><?php echo $cartao_name; ?></a></div>
                <h1 class="title-headline"><?php echo get_the_title($postID); ?></h1>
                <section class="auth top">
                    <div class="display-flex">
                        <div class="flex">
                            <div class="display-flex" style="align-items: center;">
                                <div class="foto-perfil"><a class="author-info__author-name" href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"><figure><?php echo get_avatar( $author_id, 150, '', '', array( 'class' => 'author-info__avatar-image' ) ); ?></figure></a></div>
                                <div class="flex">
                                    <div class="display-table">
                                        <div class="table">
                                            <p class="auth__title">Artigo escrito por <b><a class="author-info__author-name" href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"><?php echo get_the_author_meta( 'display_name', $author_id ); ?></a></b><small>em <?php echo get_the_date('F d, Y',$postID); ?></small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="single--article__body-grid">
                    <?php echo get_post_field('post_content', $postID); ?>
                </div>
                <div class="articles-recomendados">
                    <div class="headline">
                        <span class="headline-inner mt-0">Continue Lendo</span>
                    </div>
                    <div class="articles articles-style-2">
                    </div>
                </div>
            </article>
            <?php }} ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>