<article class="post quote">
	
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
			
			<?php if( !is_single() ) { ?> <a href="<?php the_permalink(); ?>"><?php } ?>
			
			<?php $quote = get_post_meta($post->ID, '_nectar_quote', true); ?>
			
			<div class="quote-inner">
				<h2 class="title"><?php echo $quote; ?></h2>
		    	<span class="author"> <?php the_title(); ?></span>
		    	<span class="icon"></span>
			</div><!--/quote-inner-->
			
			<?php if( !is_single() ) { ?> </a> <?php } ?>
			
			<?php $options = get_option('salient');
				if( $options['display_tags'] == true ){
					 
					if( is_single() && has_tag() ) {
					
						echo '<div class="post-tags"><h4>Tags: </h4>'; 
						the_tags('','','');
						echo '<div class="clear"></div></div> ';
						
					}
				}
			?>
			
		</div><!--/content-inner-->
		
	</div><!--/post-content-->
		
</article><!--/article-->