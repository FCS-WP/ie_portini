<?php 
    $thumbsize = !isset($thumbsize) ? oworganic_get_config( 'blog_item_thumbsize', 'full' ) : $thumbsize;
    $thumb = oworganic_display_post_thumb($thumbsize);
?>
<article <?php post_class('post post-layout post-grid v4'); ?>>
    <?php if($thumb) {?>
        <div class="top-image">
            <?php
                echo trim($thumb);
            ?>
         </div>
    <?php } ?>
    <div class="inner">
        <div class="post-layout-info">
            <a class="date" href="<?php the_permalink(); ?>"><?php the_time( get_option('date_format', 'd M, Y') ); ?></a>
        </div>
        <?php if (get_the_title()) { ?>
            <h4 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>
        <?php } ?>
    </div>
</article>