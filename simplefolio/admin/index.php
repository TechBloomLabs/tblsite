<?php

function sf_admin_head() { ?>
		<style>
		h2 { margin-bottom: 20px; }
		.title { margin: 0px !important; background: #D4E9FA; padding: 10px; font-family: Georgia, serif; font-weight: normal !important; letter-spacing: 1px; font-size: 18px; }
		.container { background: #EAF3FA; padding: 10px; }
		.maintable { font-family:"Lucida Grande","Lucida Sans Unicode",Arial,Verdana,sans-serif; background: #EAF3FA; margin-bottom: 20px; padding: 10px 0px; }
		.mainrow { padding-bottom: 10px !important; border-bottom: 1px solid #D4E9FA !important; float: left; margin: 0px 10px 10px 10px !important; }
		.titledesc { font-size: 14px; font-weight:bold; width: 220px !important; margin-right: 20px !important; }
		.forminp { width: 700px !important; valign: middle !important; }
		.forminp input, .forminp select, .forminp textarea { margin-bottom: 9px !important; background: #fff; border: 1px solid #D4E9FA; width: 500px; padding: 4px; font-family:"Lucida Grande","Lucida Sans Unicode",Arial,Verdana,sans-serif; font-size: 12px; }
		.forminp span { font-size: 11px !important; font-weight: normal !important; ine-height: 14px !important; }
		.info { background: #FFFFCC; border: 1px dotted #D8D2A9; padding: 10px; color: #333; }
		.forminp .checkbox { width:20px }
		.info a { color: #333; text-decoration: none; border-bottom: 1px dotted #333 }
		.info a:hover { color: #666; border-bottom: 1px dotted #666; }
		.warning { background: #FFEBE8; border: 1px dotted #CC0000; padding: 10px; color: #333; font-weight: bold; }
		</style>
	<?php 
	}
	
	
	$themename = "SimpleFolio";
	$shortname = "sf";

	function sf_generate_page($options){
		global $themename;
		?>
			<div class="wrap">
    			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
						<h2><?php echo $themename; ?></h2>
						<?php if ( $_REQUEST['saved'] ) { ?><div style="clear:both;height:20px;"></div><div class="warning"><?php echo $themename; ?>'s Options has been updated!</div><?php } ?>
						<?php if ( $_REQUEST['reset'] ) { ?><div style="clear:both;height:20px;"></div><div class="warning"><?php echo $themename; ?>'s Options has been reset!</div><?php } ?>	
						<!--START: GENERAL SETTINGS-->
     						<table class="maintable">
							<?php foreach ($options as $value) { ?>
									<?php if ( $value['type'] <> "heading" ) { ?>
										<tr class="mainrow">
										<td class="titledesc"><?php echo $value['name']; ?></td>
										<td class="forminp">
									<?php } ?>	
									<?php
										switch ( $value['type'] ) {
										case 'text':
									?>
		        							<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings($value['id']); } else { echo $value['std']; } ?>" />
									<?php
										break;
										case 'select':
									?>
	            						<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
	                					<?php foreach ($value['options'] as $option) { ?>
	                						<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
	                					<?php } ?>
	            						</select>
									<?php
										break;
										case 'textarea':
										$ta_options = $value['options'];
									?>
										<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="8"><?php  if( get_settings($value['id']) != "") { echo stripslashes(get_settings($value['id'])); } else { echo $value['std']; } ?></textarea>
									<?php
										break;
										case "radio":
 										foreach ($value['options'] as $key=>$option) { 
													$radio_setting = get_settings($value['id']);
													if($radio_setting != '') {
		    											if ($key == get_settings($value['id']) ) { $checked = "checked=\"checked\""; } else { $checked = ""; }
													} else {
														if($key == $value['std']) { $checked = "checked=\"checked\""; } else { $checked = ""; }
									} ?>
	            					<input type="radio" name="<?php echo $value['id']; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><?php echo $option; ?><br />
									<?php }
										break;
										case "checkbox":
										if(get_settings($value['id'])) { $checked = "checked=\"checked\""; } else { $checked = ""; }
									?>
		            				<input type="checkbox" class="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
									<?php
										break;
										case "multicheck":
 										foreach ($value['options'] as $key=>$option) {
	 											$sb_key = $value['id'] . '_' . $key;
												$checkbox_setting = get_settings($sb_key);
 												if($checkbox_setting != '') {
		    											if (get_settings($sb_key) ) { $checked = "checked=\"checked\""; } else { $checked = ""; }
												} else { if($key == $value['std']) { $checked = "checked=\"checked\""; } else { $checked = ""; }
									} ?>
	            					<input type="checkbox" class="checkbox" name="<?php echo $sb_key; ?>" id="<?php echo $sb_key; ?>" value="true" <?php echo $checked; ?> /><label for="<?php echo $sb_key; ?>"><?php echo $option; ?></label><br />
									<?php }
										break;
										case "heading":
									?>
										</table> 
		    									<h3 class="title"><?php echo $value['name']; ?></h3>
										<table class="maintable">
									<?php
										break;
										default:
										break;
									} ?>
									<?php if ( $value['type'] <> "heading" ) { ?>
										<?php if ( $value['type'] <> "checkbox" ) { ?><br/><?php } ?><span><?php echo $value['desc']; ?></span>
										</td></tr>
									<?php } ?>	
							<?php } ?>
							</table>
							<p class="submit">
								<input name="save" type="submit" value="Save changes" />    
								<input type="hidden" name="action" value="save" />
							</p>
							<div style="clear:both;"></div>
						<!--END: GENERAL SETTINGS-->
            </form>
</div><!--wrap-->
<div style="clear:both;height:20px;"></div>
 <?php
}
$sf_categories_obj = get_categories('hide_empty=0');
$sf_categories = array();
foreach ($sf_categories_obj as $sf_cat) {
	$sf_categories[$sf_cat->cat_ID] = $sf_cat->cat_name;
}
$categories_tmp = array_unshift($sf_categories, "Select a category:");
	
	$sfoptions = array();	
	$sfoptions[] = array(	"name" => "Basic Options",
							"type" => "heading");
	$sfoptions[] = array(	"name" => "Custom Logo",
							"desc" => "The complete URL to you logo.",
							"id" => $shortname."_basic_logo",
							"std" => "",
							"type" => "text");
	$sfoptions[] = array(	"name" => "Custom Favicon",
							"desc" => "The complete URL to you favicon.",
							"id" => $shortname."_basic_favicon",
							"std" => "",
							"type" => "text");
	$sfoptions[] = array(	"name" => "Site Keywords",
							"desc" => "The keywords that best describe your website seperated by a coma(<strong>,</strong>). This is a meta-tag within the HEAD tags.",
							"id" => $shortname."_seo_kw",
							"std" => "",
							"type" => "text");	
	$sfoptions[] = array(	"name" => "Site Description",
							"desc" => "A small description of your site for the meta-tag",
							"id" => $shortname."_seo_desc",
							"std" => "",
							"type" => "textarea");	
	$sfoptions[] = array(	"name" => "FeedBurner URI",
							"desc" => "Paste the ONLY your FeedBurner URI.<br/>The bold text from the following URL: http://feeds2.feedburner.com/<strong>Slimmity</strong> <br/>This will replace RSS feed link on the sidebar.",
							"id" => $shortname."_feedburner",
							"std" => "",
							"type" => "text");
	$sfoptions[] = array(	"name" => "Email Subscription",
							"desc" => "Check this if your Feedburner feed has email subscription enabled.",
							"id" => $shortname."_email",
							"std" => "",
							"type" => "checkbox");	
	$sfoptions[] = array(	"name" => "Twitter URL",
							"desc" => "Paste your twitter user name. <br/>The bold text from the following URL: http://twitter.com/<strong>Slimmity</strong>",
							"id" => $shortname."_twitter",
							"std" => "",
							"type" => "text");	
	
	$sfoptions[] = array(	"name" => "Portfolio Options",
							"type" => "heading");
	$sfoptions[] = array(	"name" => "Portfolio Category",
							"desc" => "Select the category you will post your portfolio items under.",
							"id" => $shortname."_portfolio_category",
							"std" => "Select a page:",
							"type" => "select",
							"options" => $sf_categories);
	$sfoptions[] = array(	"name" => "Welcome Title",
							"desc" => "This is the text that will apear as the header in the portfolio page.",
							"id" => $shortname."_portfolio_header",
							"std" => "",
							"type" => "text");
	$sfoptions[] = array(	"name" => "Welcome Text",
							"desc" => "Some basic text you wish to display under the Welcome Title. Can contain HTML and can be left blank",
							"id" => $shortname."_portfolio_text",
							"std" => "",
							"type" => "textarea");
	$sfoptions[] = array(	"name" => "Exclude Portfolio from Blog",
							"desc" => "Check this if you wish to exclude your portfolio posts from being displayed in other pages that isn't the portfolio page.",
							"id" => $shortname."_portfolio_exclude",
							"std" => "",
							"type" => "checkbox");
	$sfoptions[] = array(	"name" => "Items per page",
							"desc" => "Input the ammount of portfolio items you wish to display per page. Use even numbers for a better visual effect.<br/>Default is 6",
							"id" => $shortname."_portfolio_pagination",
							"std" => "",
							"type" => "text");
	$sfoptions[] = array(	"name" => "Excerpt Length",
							"desc" => "Input the ammount of characters you wish to display under the small thumbnail on the portfolio page.<br/>Default is 200",
							"id" => $shortname."_portfolio_limittext",
							"std" => "",
							"type" => "text");
	$sfoptions[] = array(	"name" => "Subcategory Navigation",
							"desc" => "If your portfolio has child categories by enableling this a small navigation will be added under the welcome text. <br/>If the category has no child categories even if this enabled the navigation will be disactivated",
							"id" => $shortname."_portfolio_nav",
							"std" => "",
							"type" => "checkbox");
							
	$sfoptions[] = array(	"name" => "Frontpage Slogan Options",
							"type" => "heading");
	$sfoptions[] = array(	"name" => "Display",
							"desc" => "Check this if you wish to display the slogan box on the front page.",
							"id" => $shortname."_slogan_status",
							"std" => "",
							"type" => "checkbox");
	$sfoptions[] = array(	"name" => "Slogan",
							"desc" => "This is the text that will apear as the header.",
							"id" => $shortname."_slogan_header",
							"std" => "",
							"type" => "text");
	$sfoptions[] = array(	"name" => "Small text",
							"desc" => "Some basic text you wish to display under your slogan",
							"id" => $shortname."_slogan_text",
							"std" => "",
							"type" => "textarea");
	$sfoptions[] = array(	"name" => "Quote Text",
							"desc" => "The text for the \"quote\" button.",
							"id" => $shortname."_slogan_quote",
							"std" => "",
							"type" => "text");
	$sfoptions[] = array(	"name" => "Quote Link",
							"desc" => "The URL to your \"quote\" page.",
							"id" => $shortname."_slogan_url",
							"std" => "http://",
							"type" => "text");
	
	$sfoptions[] = array(	"name" => "Slider Options",
							"type" => "heading");
	$sfoptions[] = array(	"name" => "Number of Slides",
							"desc" => "This must be a number. The slides will be taken from the portfolio category you selected in earlier options. Default is 5",
							"id" => $shortname."_slider_slides",
							"std" => "",
							"type" => "text");
	$sfoptions[] = array(	"name" => "Text Lenth",
							"desc" => "The ammount of characters you wish to display under the title. Default is 100",
							"id" => $shortname."_slider_chars",
							"std" => "",
							"type" => "text");
	
	$sfoptions[] = array(	"name" => "Social Options",
							"type" => "heading");
	$sfoptions[] = array(	"name" => "Display",
							"desc" => "If you wish to display the default links and text enable this.",
							"id" => $shortname."_social_status",
							"std" => "",
							"type" => "checkbox");
	$sfoptions[] = array(	"name" => "Social Box Title",
							"desc" => "The title you wish to use in the social links box in the single post page",
							"id" => $shortname."_social_title",
							"std" => "",
							"type" => "text");
	$sfoptions[] = array(	"name" => "Social Message",
							"desc" => "Some Text you wish to add under the title",
							"id" => $shortname."_social_text",
							"std" => "",
							"type" => "textarea");
							
							
	function sf_index_options() {
		global $sfoptions;
		sf_generate_page($sfoptions);
	}
	
	function sf_add_admin() {
		global $themename,$sfoptions;
		if ( $_GET['page'] == "sf-options") {
			if ( 'save' == $_REQUEST['action'] ) {
					foreach ($sfoptions as $value) {
						if($value['type'] != 'multicheck'){
							update_option( $value['id'], $_REQUEST[ $value['id'] ] ); 
						}else{
							foreach($value['options'] as $mc_key => $mc_value){
								$up_opt = $value['id'].'_'.$mc_key;
								update_option($up_opt, $_REQUEST[$up_opt] );
							}
						}
					}
					foreach ($sfoptions as $value) {
						if($value['type'] != 'multicheck'){
							if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } 
						}else{
							foreach($value['options'] as $mc_key => $mc_value){
								$up_opt = $value['id'].'_'.$mc_key;						
								if( isset( $_REQUEST[ $up_opt ] ) ) { update_option( $up_opt, $_REQUEST[ $up_opt ]  ); } else { delete_option( $up_opt ); } 
							}
						}
					}
					header("Location: admin.php?page=sf-options&saved=true");								
				die;
			}
		}
		add_menu_page("Main Options", "Theme Options", 'edit_themes', 'sf-options', 'sf_index_options');
	}
	

$theme_metaboxes = array(
		"thumb-small" => array (
			"name"		=> "thumb-small",
			"default" 	=> "",
			"label" 	=> "Small Preview Image URL",
			"type" 		=> "text",
			"desc"      => "Upload your image with 'Add Media' above post window, copy the url and paste it here. Max height and width should be: 390x200 pixels"
		),
		"thumb-large" => array (
			"name"		=> "thumb-large",
			"default" 	=> "",
			"label" 	=> "Large Preview Image URL",
			"type" 		=> "text",
			"desc"      => "Upload your image with 'Add Media' above post window, copy the url and paste it here. Max height and width should be: 900x250 pixels"
		),
	);
	
function cstheme_meta_box_content() {
	global $post, $theme_metaboxes;
	foreach ($theme_metaboxes as $theme_metabox) {
		$theme_metaboxvalue = get_post_meta($post->ID,$theme_metabox["name"],true);
		if ($theme_metaboxvalue == "" || !isset($theme_metaboxvalue)) {
			$theme_metaboxvalue = $theme_metabox['default'];
		}
		

		echo "\t".'<p>';
		echo "\t\t".'<label for="'.$theme_metabox['name'].'" style="font-weight:bold; ">'.$theme_metabox['label'].':</label>'."\n";
		echo "\t\t".'<input style="width:99%" type="'.$theme_metabox['type'].'" value="'.$theme_metaboxvalue.'" name="'.$theme_metabox["name"].'" id="'.$theme_metabox['name'].'"/><br/>'."\n";
		echo "\t\t".$theme_metabox['desc'].'</p>'."\n";				
	}
}

function cstheme_metabox_insert($pID) {
	global $theme_metaboxes;
	foreach ($theme_metaboxes as $theme_metabox) {
		$var = $theme_metabox["name"];
		if (isset($_POST[$var])) {			
			if( get_post_meta( $pID, $theme_metabox["name"] ) == "" )
				add_post_meta($pID, $theme_metabox["name"], $_POST[$var], true );
			elseif($_POST[$var] != get_post_meta($pID, $theme_metabox["name"], true))
				update_post_meta($pID, $theme_metabox["name"], $_POST[$var]);
			elseif($_POST[$var] == "")
				delete_post_meta($pID, $theme_metabox["name"], get_post_meta($pID, $theme_metabox["name"], true));
		}
	}
}

function cstheme_meta_box() {
	if ( function_exists('add_meta_box') ) {
		add_meta_box('theme-settings','SimpleFolio Custom Settings','cstheme_meta_box_content','post','normal','high');
	}
}

add_action('admin_menu', 'cstheme_meta_box');
add_action('wp_insert_post', 'cstheme_metabox_insert');
	
	add_action('admin_menu', 'sf_add_admin');
	add_action('admin_head', 'sf_admin_head');	

?>
