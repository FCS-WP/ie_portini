<?php 
global $post;
$thumbsize = !isset($thumbsize) ? oworganic_get_config( 'blog_item_thumbsize', 'full' ) : $thumbsize;
$thumb = oworganic_display_post_thumb($thumbsize);
?>
<article <?php post_class('post post-layout post-list-item'); ?>>
    <div class="list-inner ">
        <div class="flex">
            <?php
                if ( !empty($thumb) ) {
                    ?>
                    <div class="image">
                        <?php echo trim($thumb); ?>
                    </div>
                    <?php
                }
            ?>
            <div class="inner-info">

                <div class="post-layout-info">
                    <div class="date"><a href="<?php the_permalink(); ?>"><?php the_time( get_option('date_format', 'd M, Y') ); ?></a></div>
                </div>

                <?php if (get_the_title()) { ?>
                    <h4 class="entry-title">
                        <?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
                            <div class="stick-icon text-theme"><i class="ti-pin2"></i></div>
                        <?php endif; ?>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h4>
                <?php } ?>
                <?php if( !empty( get_the_excerpt() ) ){?>
                    <div class="description hidden-xs"><?php echo oworganic_substring( get_the_excerpt(), 18, '...' ); ?></div>
                <?php } ?>
                <?php if( !empty( get_the_excerpt() ) ){?>
                    <div class="description visible-xs"><?php echo oworganic_substring( get_the_excerpt(), 8, '...' ); ?></div>
                <?php } ?>
                <div class="readmore hidden-xs">
                    <a class="btn btn-theme" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'oworganic'); ?></a>
                </div>
            </div>
        </div>
    </div>
</article>