<?php get_header(); ?>
<div class="heading_article">
    <div class="container">
        <h1><?php printf( __d('%s'), '' . single_tag_title('', false ) . ''); ?></h1>
        <h2>Todos os artigos</h2>
    </div>
</div>
<div class="container">
    <div class="artigos-area">
        <div class="articles">
            <?php 
            global $wp_query;
            // O Loop
            $args = isset($_POST['query']) ? json_decode( stripslashes( $_POST['query'] ), true ) : $wp_query->query_vars;
            if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
            elseif ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
            else { $paged = 1; }
            $args['paged'] = $paged;
            $query = new WP_Query( $args );

            if( $query->have_posts() ) {
                while( $query->have_posts() ) {
                    $query->the_post();
                    $author_id = get_post_field ('post_author', get_the_ID());
                    echo '<div class="news-block-2">
                        <a href="'.get_the_permalink().'" rel="noopener noreferrer" class="picture-images">'.stcodes_generate_picture(get_the_ID()).'</a>
                        <div class="article-text">
                            <div class="display-table">
                                <div class="table">
                                    <span class="articles__category">'.stcode_artigoname(get_post_meta(get_the_ID(), 'stcode_artigo_tipo', true)).'</span>
                                    <a href="'.get_the_permalink().'" rel="noopener noreferrer"><h5 class="news-title">'.get_the_title().'</h5></a>
                                    <p class="news-tag">'.get_the_author_meta( 'display_name', $author_id ).' <i>•</i> <span>'.get_the_date('d M Y').'</span></p>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
                // Restaurar Post Data Original
                wp_reset_postdata();
            }
            ?>
        </div>
        <div class="fetch mt-30 mb-30 text-center">
            <?php
            if( 1 < $wp_query->max_num_pages ) {
                echo '<div class="button custom padding stcode_loadmore">Carregar mais</div>'; // you can use <a> as well
            }
            ?>
            <span class="load hide">Aguarde...</span>
        </div>
    </div>
</div>
<?php get_footer(); ?>