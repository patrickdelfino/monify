<?php get_header(); ?>
<div class="heading_article monify-blog-heading">
    <div class="container">
        <h1>Blog</h1>
        <h2>Todos os artigos</h2>
    </div>
</div>
<div class="container monify-blog">
    <div class="artigos-area">
        <div class="articles">
            <?php 
            // O Loop
            $publications = new WP_Query([
              'post_type' => 'post',
              'post_status' => 'publish',
              'posts_per_page' => 25,
              'orderby' => ['date' => 'DESC', 'ID' => 'DESC'],
              'order' => 'DESC',
              'paged' => 1,
            ]);

            if( $publications->have_posts() ) {
                while( $publications->have_posts() ) {
                    $publications->the_post();
                    get_template_part('inc/parts/article');
                }
                // Restaurar Post Data Original
                wp_reset_postdata();
            }
            ?>
        </div>
        <div class="fetch mt-30 mb-30 text-center">
            <?php if ($publications->max_num_pages > 1): ?><button type="button" class="button custom padding stcode_loadmore">Carregar mais</button><?php endif; ?>
            <span class="load hide">Aguarde...</span>
        </div>
    </div>
</div>
<?php get_footer(); ?>