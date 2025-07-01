<?php 
    $thumbsize = !isset($thumbsize) ? oworganic_get_config( 'blog_item_thumbsize', 'full' ) : $thumbsize;
    $thumb = oworganic_display_post_thumb($thumbsize);
?>
<article <?php post_class('post post-layout post-grid v2'); ?>>
        <?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
            <span class="post-sticky"><?php echo esc_html__('Featured','oworganic'); ?></span>
        <?php endif; ?>
        <?php if($thumb) {?>
            <div class="top-image">
                <?php
                    echo trim($thumb);
                ?>
             </div>
        <?php } ?>
        
        <div class="post-layout-info">
            <div class="date"><a href="<?php the_permalink(); ?>"><?php the_time( get_option('date_format', 'd M, Y') ); ?></a></div>
        </div>

        <?php if (get_the_title()) { ?>
            <h4 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>
        <?php } ?>
        <?php if( !empty( get_the_excerpt() ) ){?>
            <div class="description"><?php echo oworganic_substring( get_the_excerpt(), 18, '...' ); ?></div>
        <?php } ?>
        <div class="readmore">
            <a class="btn btn-theme hidden-xs" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'oworganic'); ?></a>
        </div>
</article>