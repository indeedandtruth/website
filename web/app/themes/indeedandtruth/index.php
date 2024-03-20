<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$context = Timber::context();

$context['posts'] = Timber::get_posts(array(
	'post_type' => 'post',
	'posts_per_page' => 1,
	'category_name' => 'newsletters'
));

if(class_exists('ACF')) {
	$context['partnerships'] = get_field('partnerships', 'options');
	$context['impacts'] = get_field('impacts', 'options');
	$about_id = get_field('about', 'options');
	$context['about'] = Timber::get_post($about_id);
}

Timber::render('index.twig', $context );
