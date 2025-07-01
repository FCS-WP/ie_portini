<?php
global $post;
?>
<div class="apus-social-share">
	<div class="bo-social-icons social-text">
		<?php if ( oworganic_get_config('facebook_share', 1) ): ?>
 			<a class="bo-social-facebook facebook" href="http://www.facebook.com/sharer.php?s=100&u=<?php the_permalink(); ?>" target="_blank">
				<i class="fab fa-facebook-f"></i>
			</a>
		<?php endif; ?>
		<?php if ( oworganic_get_config('twitter_share', 1) ): ?>
 			<a class="bo-social-twitter twitter" href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>" target="_blank">
				<i class="fab fa-twitter"></i>
			</a>
		<?php endif; ?>
		<?php if ( oworganic_get_config('linkedin_share', 1) ): ?>
 			<a class="bo-social-linkedin linkedin" href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" target="_blank">
				<i class="fab fa-linkedin-in"></i>
			</a>
		<?php endif; ?>
		
		<?php if ( oworganic_get_config('pinterest_share', 1) ): ?>
			<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
 			<a class="bo-social-pinterest pinterest" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&amp;media=<?php echo urlencode($full_image[0]); ?>" target="_blank">
				<i class="fab fa-pinterest-p"></i>
			</a>
		<?php endif; ?>

	</div>
</div>