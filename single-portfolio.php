<?php get_header(); ?>

<div class="container main-content">

    <div class="row">
        <div class="col span_12 section-title project-title">
            <h1><?php the_title(); ?></h1>

            <?php $portfolio_link = get_portfolio_page_link(get_the_ID()); ?>

            <div id="portfolio-nav">
                <ul>
                    <li id="prev-link"><?php next_post_link('%link'); ?></li>
                    <li id="all-items"><a href="<?php echo $portfolio_link; ?>">Back to All Portfolio Items</a></li> 
                    <li id="next-link"><?php previous_post_link('%link'); ?></li> 
                </ul>
            </div>
        </div>
    </div>

    <div class="row">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <div id="post-area" class="col span_9">

                    <?php
                    $video_embed = get_post_meta($post->ID, '_nectar_video_embed', true);
                    $video_m4v = get_post_meta($post->ID, '_nectar_video_m4v', true);

                    //Gallery
                    if (MultiPostThumbnails::has_post_thumbnail(get_post_type(), 'second-slide')) {
                        nectar_gallery($post->ID);
                    }

                    //Video
                    else if (!empty($video_embed) || !empty($video_m4v)) {

                        if (!empty($video_embed)) {
                            echo '<div class="video-wrap">' . stripslashes(htmlspecialchars_decode($video_embed)) . '</div>';
                        } else {
                            nectar_video($post->ID);
                        }
                    }

                    //Regular Featured Img
                    else {
                        if (has_post_thumbnail()) {
                            echo get_the_post_thumbnail($post->ID, 'full', array('title' => ''));
                        } else {
                            echo '<img src="' . get_template_directory_uri() . '/img/no-portfolio-item.jpg" alt="no image added yet." />';
                        }
                    }
                    ?>

                    <?php
                    //extra content 
                    $options = get_option('salient');
                    if (!empty($options['portfolio_extra_content']) && $options['portfolio_extra_content'] == 1) {

                        $portfolio_extra_content = get_post_meta($post->ID, '_nectar_portfolio_extra_content', true);

                        if (!empty($portfolio_extra_content)) {
                            echo '<div id="portfolio-extra">' . do_shortcode($portfolio_extra_content) . '</div>';
                        }
                    }
                    ?>

                    <div class="comments-section">
                        <?php comments_template(); ?>
                    </div>   

                </div><!--/span_9-->



                <div id="sidebar" class="col span_3 col_last" data-follow-on-scroll="<?php echo (!empty($options['portfolio_sidebar_follow']) && $options['portfolio_sidebar_follow'] == 1) ? 1 : 0; ?>">

                    <div id="sidebar-inner">

                        <div id="project-meta">

                            <ul>
                                <li>
                                    <div class="nectar-love-wrap">
                                        <?php //if( function_exists('nectar_love') ) nectar_love(); ?>
                                        
                                        <div class="g-plusone" data-size="medium" data-href="<?php the_permalink(); ?>"></div>
                                        <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-hashtags="acroweb">Tweet</a>
                                        <div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false"></div>
                                        
                                        
                                    </div><!--/nectar-love-wrap-->
                                </li>

                                <?php
                                $terms = get_the_terms($post->id, "project-type");
                                $project_cats = NULL;

                                if (!empty($terms)) {
                                    foreach ($terms as $term) {
                                        $project_cats .= strtolower($term->slug) . ' ';
                                    }
                                }

                                $options = get_option('salient');

                                if (!empty($options['portfolio_date']) && $options['portfolio_date'] == 1) {
                                    ?>
                                    <li>
                                        <?php //the_time('F d, Y'); ?>
                                    </li>
                                <?php } elseif (!empty($project_cats)) {
                                    ?>
                                    <li>
                                        <?php echo '<span>In: </span> ' . $project_cats; ?>
                                    </li>
                                <?php } ?>


                            </ul>

                        </div><!--project-meta-->

                        <?php the_content(); ?>


                        <?php
                        $project_attrs = get_the_terms($post->ID, 'project-attributes');
                        if (!empty($project_attrs)) {
                            ?>
                            <ul class="project-attrs checks">
                                <?php
                                foreach ($project_attrs as $attr) {
                                    echo '<li>' . $attr->name . '</li>';
                                }
                                ?>
                            </ul>
                        <?php } ?>


                    </div>

                </div><!--/sidebar-->

            <?php endwhile;
        endif; ?>

    </div>

</div><!--/container-->

<?php get_footer(); ?>