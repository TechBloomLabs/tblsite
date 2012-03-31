<?php 
	/* Register Widgets */
		if ( function_exists('register_sidebar') ) {
			register_sidebar(array(
				'name' => 'Sidebar Widget',
				'before_widget' => '<div class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3>',
				'after_title' => '</h3>',
			));
			register_sidebar(array(
				'name' => 'Home Widget',
				'before_widget' => '<div class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3>',
				'after_title' => '</h3>',
			));
		}
		
	/* Un-Register WP-PageNavi Style Page Include */
		function my_deregister_styles() {
			wp_deregister_style('wp-pagenavi');
		}
		add_action('wp_print_styles','my_deregister_styles',100);
		
	/* Function To Limit Output Of Content.*/
		function the_content_limit($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
			$content = get_the_content($more_link_text, $stripteaser, $more_file);
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			$content = strip_tags($content);

		   if (strlen($_GET['p']) > 0) {
			  echo $content;
		   }
		   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
				$content = substr($content, 0, $espacio);
				$content = $content;
				echo $content;
				echo "...";
		   }
		   else {
			  echo $content;
		   }
		}
		
	/* Exclude Portfolio Category & Child Categories From Blog Posts */
		function sf_portfolio_filter($query) {
			global $wpdb;
			if(!is_archive() && !is_admin() && !is_single()){
				$category = sf_get_category_id(get_option('sf_portfolio_category'));
				if (!empty($category) && get_option('sf_portfolio_exclude')) {
					$array = array($category => $category);
					$array2 = array();
					$categories = get_categories('child_of='.$category);
					foreach($categories as $k) {
						$array2[$k->term_id] = $k->term_id;
					}
					$array2 = array_merge($array,$array2);
					$query = sf_portfolio_remove_category($query,$array2);
				}
			}
			return $query;
		}
		function sf_portfolio_remove_category($query,$category){
			$cat = $query->get('category__in');
			$cat2 = array_merge($query->get('category__not_in'),$category);
			if($cat && $cat2){
				foreach($cat2 as $k=>$c){
					if(in_array($c,$cat)){
						unset($cat2[$k]);
					}
				}
			}
			$query->set('category__not_in',$cat2);
		 
			return $query;
		}
		add_filter('pre_get_posts', 'sf_portfolio_filter');
		
	/* Exclude Portfolio Category & Child Categories From Category List And Dropdown Widget */
		function sf_category_filter($args) {
			$category = sf_get_category_id(get_option('sf_portfolio_category'));
			if (!empty($category) && get_option('sf_portfolio_exclude')) {
				$myarray = array(
						'exclude'    => $category,
						'exclude_tree'    => $category,
						);
				$args = array_merge($args, $myarray);
			}
			return $args;
		}
		add_filter('widget_categories_args', 'sf_category_filter');
		add_filter('widget_categories_dropdown_args', 'sf_category_filter');
	
	/* Generate a list of child categories of the portfolio category for filtering on the portfolio items by category */
		function sf_list_portfolio_child_categories($topcat,$active,$pagepermalink) {
			$categories = get_categories('child_of='.$topcat);
			if (hasQuestionMark($pagepermalink)) {
				$pagepermlinkadd = $pagepermalink."&";
			}
			else {
				$pagepermlinkadd = $pagepermalink."?";
			}
			$array2 = array();
			foreach($categories as $k) {
				$array2[$k->term_id] = $k->name;
			}
			foreach ($array2 as $x => $y) {
				if ($x == $active) { $addtoclass = " class=\"active\""; }
				echo "<li".$addtoclass."><a href=\"".$pagepermlinkadd."pcat=".$x."\">".$y."</a></li>";
				unset($addtoclass);
			}
		}
	
	/* Go threw a string to see if it contains a certain character */
		function hasQuestionMark($string) {
			$length = strlen($string);
			for($i = 0; $i < $length; $i++) {
				$char = $string[$i];
				if($char == '?') { return true; }
			}
			return false;
		}

	/* Get the Category ID */
		function sf_get_category_id($cat_name) {
			$categories = get_categories();
			foreach($categories as $category){ //loop through categories
				if($category->name == $cat_name){
					$cat_id = $category->term_id;
					break;
				}
			}
			if (empty($cat_id)) { return 0; }
			return $cat_id;
		}
	
	/**
	 * Tests if any of a post's assigned categories are descendants of target categories
	 *
	 * @param int|array $cats The target categories. Integer ID or array of integer IDs
	 * @param int|object $_post The post. Omit to test the current post in the Loop or main query
	 * @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
	 * @see get_term_by() You can get a category by name or slug, then pass ID to this function
	 * @uses get_term_children() Passes $cats
	 * @uses in_category() Passes $_post (can be empty)
	 * @version 2.7
	 * @link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
	 */
		function post_is_in_descendant_category( $cats, $_post = null ) {
			foreach ( (array) $cats as $cat ) {
				// get_term_children() accepts integer ID only
				$descendants = get_term_children( (int) $cat, 'category');
				if ( $descendants && in_category( $descendants, $_post ) )
					return true;
			}
			return false;
		}
		
	/* Generate Custom Logo & Favicon */
		function sf_get_logo() {
			$default_logo = get_bloginfo('template_directory')."/images/logo.png";
			$custom_logo = get_option('sf_basic_logo');
			$logo = (empty($custom_logo)) ? $default_logo : $custom_logo;
			return $logo;
		}
		function sf_get_favicon() {
			$default_favicon = get_bloginfo('template_directory')."/images/favicon.ico";
			$custom_favicon = get_option('sf_basic_favicon');
			$favicon = (empty($custom_favicon)) ? $default_favicon : $custom_favicon;
			return $favicon;
		}
		
	/* Include Admin Option Panel File */
		include(TEMPLATEPATH . "/admin/index.php");

	/* RSS Custom Widget */
		function sf_rss_widget($args) {
			extract($args);
			?>
						<div class="widget widget_rssfeed">
							<ul>
								<?php if (get_option('sf_feedburner')): ?> <li class="rss"><a href="<?php echo "http://feeds2.feedburner.com/".get_option('sf_feedburner'); ?>">Subscribe to RSS Feed</a></li> 
								<?php else: ?> <li class="rss"><a href="<?php bloginfo('rss2_url'); ?>">Subscribe to RSS Feed</a></li> <?php endif; ?>
								
								<?php if (get_option('sf_email') && get_option('sf_feedburner')) { ?><li class="email"><a href="http://feedburner.google.com/fb/a/mailverify?uri=<?php echo get_option('sf_feedburner'); ?>&amp;loc=en_US">Subscribe by Email</a></li> <?php } ?>
								<?php if (get_option('sf_twitter')) { ?><li class="twitter"><a href="<?php echo "http://twitter.com/".get_option('sf_twitter'); ?>">Follow me on Twitter</a></li> <?php } ?>
							</ul>
						</div>
			<?php
		}
		function sf_widgets() {
			register_sidebar_widget('RSS Feed Subscribe', 'sf_rss_widget');
		}
		add_action('widgets_init','sf_widgets');
?>
