<article class="post link">
	
	<div class="post-content">
		
		<?php if( !is_single() ) { ?>
			
			<div class="post-meta">
				<div class="date">
					<span class="month"><?php the_time('M'); ?></span>
					<span class="day"><?php the_time('d'); ?></span>
					<?php $options = get_option('salient'); 
					if(!empty($options['display_full_date']) && $options['display_full_date'] == 1)
						echo '<span class="year">'. get_the_time('Y') .'</span>';
					?>
				</div><!--/date-->
				
				
							
			</div><!--/post-meta-->
		
		<?php } ?>
		
		<div class="content-inner">
			
			<?php $link = get_post_meta($post->ID, '_nectar_link', true); ?>
			
			<a target="_blank" href="<?php echo $link; ?>">
				
				<div class="link-inner">
					<h2 class="title"><?php the_title(); ?></h2>
			    	<span class="destination"> <?php echo $link; ?></span>
			    	<span class="icon"></span>
				</div><!--/link-inner-->
			
			</a>
			
		</div><!--/content-inner-->
		
	</div><!--/post-content-->
		
</article><!--/article-->