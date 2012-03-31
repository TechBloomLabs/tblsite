<?php
/*
Template Name: Portfolio
*/
?>

			<?php get_header(); ?>

				<div class="portfolio">
					<?php if (get_option('sf_portfolio_header') && get_option('sf_portfolio_text')) { ?>
					<div class="title">
						<h2><?php echo stripslashes(get_option('sf_portfolio_header')); ?></h2>
						<p><?php echo stripslashes(get_option('sf_portfolio_text')); ?></p>
					</div>
					<?php } ?>
					<?php 
						$category = sf_get_category_id(get_option('sf_portfolio_category'));
						$categories = get_categories('child_of='.$category);
						$ppp = (get_option('sf_portfolio_pagination')) ? get_option('sf_portfolio_pagination') : 6;
						if (get_option('sf_portfolio_nav')) {
						if (!empty($categories)) {
							if (isset($_GET[pcat])) {
								$pcat = $_GET[pcat];
							}
							else { $addtoclass = " class=\"active\""; }
					?>
					<div class="portfnav">
						<ul>
							<li><span>Select a Category:</span></li>
							<li<?=$addtoclass; ?>><a href="<?php echo get_permalink(); ?>">All</a></li>
							<?php sf_list_portfolio_child_categories($category,$pcat,get_permalink()); ?>
						</ul>
					</div>
					<?php } }?>
					<div id="folio">
					<?php
						$category = ($pcat) ? $pcat : $category;
						$temp = $wp_query;
						$wp_query= null;
						$wp_query = new WP_Query();
						$wp_query->query('showposts='.$ppp.'&cat='.$category.'&paged='.$paged);
						$limit_text = (get_option('sf_portfolio_limittext')) ? get_option('sf_portfolio_limittext') : 200;
						while ($wp_query->have_posts()) : $wp_query->the_post();
							$do_not_duplicate = $post->ID; 
							$thumb = get_post_meta($post->ID, 'thumb-small', true);
							if (empty($thumb)) { continue; }
							else { ?>
							<div class="item">
								<a href="<?php the_permalink(); ?>"><img src="<?php echo $thumb; ?>" alt="<?php the_title() ?>" /></a>
								<h2><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
								<p><?php the_content_limit($limit_text, ''); ?></p>
							</div>
							
							<?php } 
						endwhile; 
					?>
					</div>
					
					<?php 
					if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
					else { 
					?>
					<div class="navigation">
						<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
						<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
					</div>
					<?php } ?>
					
					<?php $wp_query = null; $wp_query = $temp;?>
				</div>

			<?php get_footer(); ?>
