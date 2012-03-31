			<?php get_header(); ?>

				<div class="content">
					
				<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					
					<div class="blogpost">
						<div class="comments"><?php comments_popup_link('0', '1', '%'); ?></div>
						<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class="meta">Posted <?php the_time('F jS, Y') ?> in <?php the_category(', ') ?> by <?php the_author() ?></div>
						<div class="entry">
							<?php the_excerpt(); ?>
						</div>
					</div>
					
				<?php endwhile; ?>
					
					<?php 
					if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
					else { 
					?>
					<div class="navigation">
						<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
						<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
					</div>
					<?php } ?>
					
				<?php else : ?>
					<?php include_once(TEMPLATEPATH."/page-error.php"); ?>
				<?php endif; ?>
				
				</div>
				
			<?php get_sidebar(); ?>
			<?php get_footer(); ?>
