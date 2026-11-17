<?php get_header(); 
$author_id = get_post_field ('post_author', $post->ID); ?>
<div class="container single">
    <div class="row">
        <div class="column column-12 column-8">
            <?php
            if (have_posts()) { while (have_posts() ) { the_post(); ?>
            <article class="mb-48 mb-64">
                <div class="meta-header">
                    <?php $categories = get_the_category(); ?>
                    <?php if ($categories): ?>
                        <?php $category_url = get_category_link($categories[0]->term_id); ?>
                        <?php if (!is_wp_error($category_url)): ?>
                            <a href="<?php echo esc_url($category_url); ?>" rel="category tag"><?php echo esc_html($categories[0]->name); ?></a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <h1 class="title-headline"><?php echo get_the_title(get_the_ID()); ?></h1>
                <section class="auth top">
                    <div class="display-flex">
                        <div class="flex">
                            <div class="display-flex" style="align-items: center;">
                                <div class="foto-perfil"><a class="author-info__author-name" href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"><figure><?php echo get_avatar( $author_id, 150, '', '', array( 'class' => 'author-info__avatar-image' ) ); ?></figure></a></div>
                                <div class="flex">
                                    <div class="display-table">
                                        <div class="table">
                                            <p class="auth__title">Artigo escrito por <b><a class="author-info__author-name" href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"><?php echo get_the_author_meta( 'display_name', $author_id ); ?></a></b><small>em <?php echo get_the_date('F d, Y',get_the_ID()); ?></small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="single--article__body-grid">
                    <?php the_content(); ?>
                </div>
                <div class="articles-recomendados">
                    <div class="headline">
                        <h2>Continue Lendo</h2>
                    </div>
                    <div class="articles articles-style-2">
                        <?php
                        $tags = wp_get_post_terms( get_the_ID(), 'category');
                        if ($tags) {

                            // Get iTags
                            $itag[1] = isset( $tags[0] ) ? $tags[0]->term_id : null;
                            $itag[2] = isset( $tags[1] ) ? $tags[1]->term_id : null;
                            $itag[3] = isset( $tags[2] ) ? $tags[2]->term_id : null;

                            // The Args
                            $args = array(
                                'post_type'      => 'post',
                                'posts_per_page' => 4,
                                'post__not_in'   => array(get_the_ID()),
                                'order'          => 'asc',
                                'orderby'        => 'rand',

                                // Check relationship
                                'tax_query' => array(
                                    'relation' => 'OR',
                                    array(
                                        'taxonomy' => 'category',
                                        'terms'    => $itag[1],
                                        'field'    => 'id',
                                        'operator' => 'IN'
                                    ),
                                    array(
                                        'taxonomy' => 'category',
                                        'terms'    => $itag[2],
                                        'field'    => 'id',
                                        'operator' => 'IN'
                                    ),
                                    array(
                                        'taxonomy' => 'category',
                                        'terms'    => $itag[3],
                                        'field'    => 'id',
                                        'operator' => 'IN'
                                    )
                                )
                            );

                            $relateds = get_posts($args);
                            $i = 0;
                            $loops = '';
                            if( $relateds ) {
                                foreach($relateds as $related) {
                                    $author_id = get_post_field ('post_author', $related->ID);
                                    echo '<div class="news-block-2">
                                        <a href="'.get_the_permalink($related->ID).'" rel="noopener noreferrer" class="picture-images">'.stcodes_generate_picture($related->ID).'</a>
                                        <div class="article-text">
                                            <div class="display-table">
                                                <div class="table">
                                                    <span class="articles__category">'.stcode_artigoname(get_post_meta($related->ID, 'stcode_artigo_tipo', true)).'</span>
                                                    <a href="'.get_the_permalink($related->ID).'" rel="noopener noreferrer"><h5 class="news-title">'.get_the_title($related->ID).'</h5></a>
                                                    <p class="news-tag">'.get_the_author_meta( 'display_name', $author_id ).' <i>•</i> <span>'.get_the_date('d M Y',$related->ID).'</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                }
                            }
                            // Restaurar Post Data Original
                            wp_reset_postdata();
                        }
                        ?>
                    </div>
                </div>
            </article>
            <?php }} ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>