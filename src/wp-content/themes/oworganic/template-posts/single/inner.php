<?php
$post_format = get_post_format();
global $post;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="top-info">
        <div class="date"><a href="<?php the_permalink(); ?>"><?php the_time( get_option('date_format', 'd M, Y') ); ?></a></div>
    </div>
    <?php if (get_the_title()) { ?>
        <h1 class="entry-title-detail">
            <?php the_title(); ?>
        </h1>
    <?php } ?>

    <div class="entry-thumb-detail <?php echo  (!has_post_thumbnail() ? 'no-thumb' : ''); ?>">
        <?php
            $thumb = oworganic_post_thumbnail();
            echo trim($thumb);
        ?>
    </div>

	<div class="entry-content-detail">
        <div class="wrapper-small">
        	<div class="single-info">
                <div class="entry-description clearfix">
                    <?php
                        the_content();
                    ?>
                </div><!-- /entry-content -->
        		<?php
                wp_link_pages( array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'oworganic' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                    'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'oworganic' ) . ' </span>%',
                    'separator'   => '',
                ) );
                ?>
                <?php  
                    $posttags = get_the_tags();
                ?>
                <?php if( !empty($posttags) || oworganic_get_config('show_blog_social_share', false) ){ ?>
            		<div class="tag-social flex-middle-sm">
                        <?php oworganic_post_tags(); ?>
                        <div class="ali-right">
                			<?php if( oworganic_get_config('show_blog_social_share', false) ) {
                				get_template_part( 'template-parts/sharebox-text' );
                			} ?>
                        </div>
            		</div>
                <?php } ?>

                <?php 
                //Previous/next post navigation.
                the_post_navigation( array(
                    'next_text' => 
                        '<div class="inner">'.
                        '<div class="navi">'. esc_html__( 'Next Post', 'oworganic' ) . '<i class="ti-angle-right"></i></div>'.
                        '</div>',
                    'prev_text' => 
                        '<div class="inner">'.
                        '<div class="navi"><i class="ti-angle-left"></i>' . esc_html__( 'Previous Post', 'oworganic' ) . '</div>'.
                        '</div>',
                ) );
                ?>
        	</div>
        </div>
    </div>
</article>