<?php get_header(); 
$author_id = get_post_field ('post_author', $post->ID); ?>
<div class="container single">
    <div class="row">
        <div class="column column-12 column-8">
            <?php
            if (have_posts()) { while (have_posts() ) { the_post(); ?>
            <article class="mb-48 mb-64">
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
            </article>
        	<?php }} ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>