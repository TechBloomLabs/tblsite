<?php
/*
Template Name: Home
*/
?>

<?php get_header(); ?>


			
				<div id="slider">
                    <ul id="sliderContent">
						<?php 
							$category = get_option('sf_portfolio_category');
							$slide_count = (get_option('sf_slider_slides')) ? get_option('sf_slider_slides') : 5;
							$text_count = (get_option('sf_slider_chars')) ? get_option('sf_slider_chars') : 100;
							$my_query = new WP_Query('showposts='.$slide_count.'&category_name='.$category);
							while ($my_query->have_posts()) : $my_query->the_post();
								$do_not_duplicate = $post->ID; 
								$thumb = get_post_meta($post->ID, 'thumb-large', true);
								?>
									<li class="sliderImage">
										<a href="<?php the_permalink(); ?>"><img src="<?php echo $thumb; ?>" alt="<?php the_title() ?>" /></a>
										<span class="bottom"><h3><?php the_title() ?></h3> <?php the_content_limit($text_count, ''); ?></span>
									</li>
								<?php 
							endwhile;
						?>
                       
                        <div class="clear sliderImage"></div>
                    </ul>
                </div>
				<?php if (get_option('sf_slogan_status')) { ?>
				<div class="slogan">
					<div class="qbutton"><a href="<?php echo stripslashes(get_option('sf_slogan_url')); ?>"><?php echo stripslashes(get_option('sf_slogan_quote')); ?></a></div>
					<h2><?php echo stripslashes(get_option('sf_slogan_header')); ?></h2>
					<p><?php echo stripslashes(get_option('sf_slogan_text')); ?></p>
				</div>
				<?php } ?>
				
				<div class="home_widgets">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Widget') ) : ?>
					<?php endif; ?>
				</div>
			


<?php get_footer(); ?>
