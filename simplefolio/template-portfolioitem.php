				<div class="content fullwidth">
					<h2 class="title"><?php the_title(); ?></h2>
					<?PHP $thumb = get_post_meta($post->ID, 'thumb-large', true); ?>
					<img src="<?php echo $thumb; ?>" alt="<?php the_title(); ?>" class="thumblarge"/>
					<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
					<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				</div>
