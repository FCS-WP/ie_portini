<?php
	$columns = oworganic_get_config('blog_columns', 1);
	$bcol = floor( 12 / $columns );
	$args['inner_item'] = !isset($args['inner_item']) ? 'list-v2' : $args['inner_item'];
?>
<div class="layout-posts-list">
    <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'template-posts/loop/inner',$args['inner_item'] ); ?>
    <?php endwhile; ?>
</div>