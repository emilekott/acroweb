<?php 
/*template name: Portfolio */
get_header(); 

$options = get_option('salient'); 

$cols = (!empty($options['main_portfolio_layout'])) ? $options['main_portfolio_layout'] : '3' ;
$span_num = (!empty($cols) && $cols == '3') ? '4' : '3';
?>

<script>
	jQuery(document).ready(function($){
	
	    var $container = $('#portfolio');
	    
	    //load with opacity if fade in is off
	    if($('#portfolio').attr('data-fade') != 1) { $('#portfolio.portfolio-items .col.span_<?php echo $span_num; ?>').css('opacity',1); }
	    
	    //else show the loading gif
	    else { $('.container.main-content').before('<span id="portfolio-loading"><span>'); }
	    
	    $(window).load(function(){
	    	// initialize isotope
			$container.isotope({
			  itemSelector : '.element',
			  filter: '*',
			  masonry: { columnWidth: $container.width() / <?php echo $cols; ?> }
			});
			
			//fade in
			if($('#portfolio').attr('data-fade') == 1) {
				
				//fadeout the loading animation
				$('#portfolio-loading').stop(true,true).fadeOut(300);
				
				//fadeIn items one by one
				$('#portfolio.portfolio-items .col.span_<?php echo $span_num; ?>').css('opacity',0);
				$('#portfolio.portfolio-items .col.span_<?php echo $span_num; ?>').each(function(i){
					$(this).delay(i*150).animate({'opacity':1},350);
				});
				
			}

	    });
		
		// filter items when filter link is clicked
		$('#portfolio-filters ul li a').click(function(){
		  var selector = $(this).attr('data-filter');
		  $container.isotope({ filter: selector });
		  
		  //active classes
		  $('#portfolio-filters ul li a').removeClass('active');
		  $(this).addClass('active');
		  
		  return false;
		});
		
		$('#portfolio-filters > a').click(function(){
			return false;
		});
		
		$(window).smartresize(function(){
		  $container.isotope({
		    masonry: { columnWidth: $container.width() / <?php echo $cols; ?> }
		  });
		});
		
		//clean up footer padding 
		if( $('#call-to-action').length > 0 ){ $('#call-to-action').css('margin-top','9px'); }
		else { $('#footer-outer').css('margin-top','9px'); }
		
		//more padding if using header bg on 4 col
		if( $('#page-header-bg').length > 0 && <?php echo $cols; ?> == 4) { $('#page-header-bg').css('margin-bottom','3.3em'); }
				
	});
</script>

<?php nectar_page_header($post->ID); ?>


<div class="container" data-col-num="cols-<?php echo $cols; ?>">

	
	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
		
		<div class="container main-content">
			<div class="row">	
				<?php the_content(); ?>
			</div>
		</div>

	<?php endwhile; endif; ?>


	<div id="portfolio" class="row portfolio-items" data-fade="<?php echo (!empty($options['portfolio_fade_in']) && $options['portfolio_fade_in'] == 1) ? '1' : '0'; ?>">
		<?php 

		$portfolio = array(
			'posts_per_page' => '-1',
			'post_type' => 'portfolio'
		);
		
		$wp_query = new WP_Query($portfolio);
		
		if(have_posts()) : while(have_posts()) : the_post(); ?>
			
			
			<?php 
				
			   $terms = get_the_terms($post->id,"project-type");
			   $project_cats = NULL;
			   
			   if ( !empty($terms) ){
			     foreach ( $terms as $term ) {
			       $project_cats .= strtolower($term->slug) . ' ';
			     }
			   }

			?>
			
			<div class="col span_<?php echo $span_num; ?> element <?php echo $project_cats; ?>">
				
				
				<div class="work-item">
					
					<?php
					//custom thumbnail
					$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
					
					if( !empty($custom_thumbnail) ){
						echo '<img class="custom-thumbnail" src="'.$custom_thumbnail.'" alt="'. get_the_title() .'" />';
					}
					else {
						
						if ( has_post_thumbnail() ) {
							 echo get_the_post_thumbnail($post->ID, 'portfolio-thumb', array('title' => '')); 
						} 
						//no image added
						else {
							 echo '<img src="'.get_template_directory_uri().'/img/no-portfolio-item-small.jpg" alt="no image added yet." />';
						 } 
					 } ?>
					
					<div class="work-info-bg"></div>
					<div class="work-info">
						
						<div class="vert-center">
							<?php 
							
							$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  							
							$video_embed = get_post_meta($post->ID, '_nectar_video_embed', true);
							$video_m4v = get_post_meta($post->ID, '_nectar_video_m4v', true);
						
							//video 
						    if( !empty($video_embed) || !empty($video_m4v) ) {

							    if( !empty( $video_embed ) ) {
							    	
							    	echo '<a href="#video-popup-'.$post->ID.'" class="pp">'.__("Watch Video", NECTAR_THEME_NAME).'</a> ';
									echo '<div id="video-popup-'.$post->ID.'">';
							        echo '<div class="video-wrap">' . stripslashes(htmlspecialchars_decode($video_embed)) . '</div>';
									echo '</div>';
							    } 
							    
							    else {
									 echo '<a href="'.get_template_directory_uri(). '/includes/portfolio-functions/video.php?post-id=' .$post->ID.'&iframe=true&width=854" class="pp" >'.__("Watch Video", NECTAR_THEME_NAME).'</a> ';	 
							     }
	
					        } 
							
							//image
						    else {
						       //echo '<a href="'. $featured_image[0].'" class="pp">'.__("View Larger", NECTAR_THEME_NAME).'</a> ';
						    }
						    $title = get_the_title($post->ID);
						    echo '<a href="' . get_permalink() . '">'.__($title, NECTAR_THEME_NAME).'</a>'; ?>
						    
						</div><!--/vert-center-->
						
					</div>
				</div><!--work-item-->
				
				<div class="work-meta">
					
					
			
		

				</div>
				
			</div><!--/col-->
			
		<?php endwhile; endif; ?>
	</div><!--/portfolio-->

	
	<?php 

	 if( get_next_posts_link() || get_previous_posts_link() ) { ?>
		<div id="pagination">
			<div class="prev"><?php previous_posts_link('&laquo; Previous Entries'); ?></div>
			<div class="next"><?php next_posts_link('Next Entries &raquo;',''); ?></div>
		</div>	
	<?php } ?>
	
</div><!--/container-->

<?php get_footer(); ?>