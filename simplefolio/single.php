<?php get_header(); ?>

				<div class="content">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php 
						$category = sf_get_category_id(get_option('sf_portfolio_category'));
						if (in_category($category) || post_is_in_descendant_category($category)) { include(TEMPLATEPATH . "/template-portfolioitem.php"); $footer = "no"; }
						else {
					?>
					<div class="blogpost">
						<div class="comments"><?php comments_number('0', '1', '%'); ?></div>
						<h2 class="title"><?php the_title(); ?></h2>
						<div class="meta">Posted <?php the_time('F jS, Y') ?> in <?php the_category(', ') ?> <?php the_tags( 'and tagged ', ', ', ' '); ?> by <?php the_author() ?></div>
						<div class="entry">
							<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
							<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						</div>
					</div>
					
					<?php if (get_option('sf_social_status')) { ?>
					<div class="social">
						<h3><?php echo stripslashes(get_option('sf_social_title')); ?></h3>
						<p>
							<?php echo stripslashes(get_option('sf_social_text')); ?>
						</p>
						<ul>
							<li class="designfloat"><a href="http://www.designfloat.com/submit.php?url=<?php the_permalink(); ?>&amp;title=<?php the_title_attribute() ?>">DesignFloat</a></li>
							<li class="delicious"><a href="http://del.icio.us/post?url=<?php the_permalink(); ?>&amp;title<?php the_title_attribute() ?>">Delicious</a></li>
							<li class="digg"><a href="http://digg.com/submit?phase=2&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title_attribute() ?>">Digg</a></li>
							<li class="stumbleupon"><a href="http://www.stumbleupon.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php the_title_attribute() ?>">StumbleUpon</a></li>
							<li class="reddit"><a href="http://reddit.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>">Reddit</a></li>
							<li class="technorati"><a href="http://technorati.com/faves?add=<?php the_permalink(); ?>">Technorati</a></li>
						</ul>
					</div>
					<?php } ?>
					<?php comments_template(); ?>
					<?php } ?>
					<?php endwhile; else: ?>
					
							<?php include_once(TEMPLATEPATH."/page-error.php"); ?>
					
					<?php endif; ?>

				</div>

<?php if ($footer != "no") { get_sidebar();  } ?>
<?php get_footer(); ?>
