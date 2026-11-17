<?php
$author_id = get_post_field('post_author', get_the_ID());
$type = get_post_meta(get_the_ID(), 'stcode_artigo_tipo', true);
$category_label = stcode_artigoname($type);
if ($category_label === 'Indefinido') {
    $categories = get_the_category();
    $category_label = $categories ? $categories[0]->name : 'Artigos';
}
?>
<div class="news-block-2">
	<a href="<?php echo get_the_permalink(); ?>" rel="noopener noreferrer" class="picture-images"><?php echo stcodes_generate_picture(get_the_ID()); ?></a>
	<div class="article-text">
		<div class="display-table">
			<div class="table">
				<span class="articles__category"><?php echo esc_html($category_label); ?></span>
				<a href="<?php echo get_the_permalink(); ?>" rel="noopener noreferrer"><h5 class="news-title"><?php echo get_the_title(); ?></h5></a>
				<p class="news-tag"><?php echo get_the_author_meta( 'display_name', $author_id ); ?> <i>•</i> <span><?php echo get_the_date('d M Y'); ?></span></p>
			</div>
		</div>
	</div>
</div>