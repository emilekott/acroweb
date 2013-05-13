<?php get_header(); ?>

<div class="container main-content">
	
	<?php if(get_post_format() != 'quote' && get_post_format() != 'quote') { ?>
		
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div class="row">
				<div class="col span_12 section-title blog-title">
					<h1><?php wp_title("",true); ?></h1>
					
					<div id="single-below-header">
						<?php echo __('Posted by', NECTAR_THEME_NAME); ?> <?php the_author_posts_link(); ?> | <?php the_category(', '); ?>
                                                <div class="clear social">
                                                <div class="g-plusone" data-size="medium" data-href="<?php the_permalink(); ?>"></div>
                                                <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-hashtags="acroweb">Tweet</a>
                                                <div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false"></div>
                                                </div>
					</div><!--/single-below-header-->
					
					<div id="single-meta">
						<ul>
                                                        <li>
								<?php the_time('F d, Y'); ?>
							</li>
						</ul>
					</div><!--/single-meta-->
				</div><!--/section-title-->
			</div><!--/row-->
			
		<?php endwhile; endif; ?>
		
	<?php } ?>
		
	<div class="row">
		
		<div id="post-area" class="col span_9">
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
				
				<?php get_template_part( 'includes/post-templates/entry', get_post_format() ); ?>
		
			<?php endwhile; endif; ?>
			
			<?php wp_link_pages(); ?>
			
			<?php $options = get_option('salient');
				if( !empty($options['author_bio']) && $options['author_bio'] == true ){ 
					
					$grav_size = 80;
					if(!empty($options['author_gravatar_size'])) $grav_size = $options['author_gravatar_size'];
				?>
					
					<div id="author-bio">
						<?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), $grav_size ); }?>
						<div id="author-info">
							<h3>About <?php the_author(); ?></h3>
							<p><?php the_author_meta('description'); ?></p>
						</div>
						
						<div class="clear"></div>
						
					</div>
					
			<?php } ?>
			
			<div class="comments-section">
   			   <?php comments_template(); ?>
			 </div>   
			 
		</div><!--/span_9-->
		
		<div id="sidebar" class="col span_3 col_last">
			<?php get_sidebar(); ?>
		</div><!--/sidebar-->
			
	</div><!--/row-->
	
</div><!--/container-->
	
<?php get_footer(); ?>