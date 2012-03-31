<?php
/*
Template Name: Redirect
*/
$location = get_post_meta($post->ID, 'redirect', true);
wp_redirect($location);
?>

