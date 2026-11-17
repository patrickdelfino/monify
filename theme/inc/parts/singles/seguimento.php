<?php get_header(); ?>
<?php global $postID; ?>
<div class="container seguimento">
    <div class="row">
        <div class="column column-12 column-8 auto-align">
        	<h1 class="title-headline"><?php echo get_the_title($postID); ?></h1>
        	<div class="single--article__body-grid">
        		<?php
        		$post_content = get_post_field('post_content', $postID); 
        		echo do_shortcode($post_content);
        		?>
            </div>
        </div>
        <div class="column column-12 column-3">
            <div class="sidebar">
                <?php if ( is_active_sidebar( 'sidebar-seguimento' ) ) : ?>
                    <?php dynamic_sidebar( 'sidebar-seguimento' ); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>