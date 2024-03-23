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

$newsletters_cat = get_category_by_slug('newsletters');

$context['posts'] = Timber::get_posts(array(
	'post_type' => 'post',
	'posts_per_page' => 1,
	'cat' => $newsletters_cat->term_id
));

$context['more_posts'] = get_category_link($newsletters_cat->term_id);

if(class_exists('ACF')) {
	$hero_image = get_field('hero_image', 'options');
	if($hero_image) {
		$context['hero_image'] = Timber::get_post($hero_image);
		$context['hero_tagline'] = get_field('hero_tagline', 'options');
		$context['gradient'] = true;
	}
	$context['partnerships'] = get_field('partnerships', 'options');
	$context['partnerships_link'] = get_field('partnerships_link', 'options');
	$context['impacts'] = get_field('impacts', 'options');
	$context['impacts_link'] = get_field('impacts_link', 'options');
	$about_id = get_field('about', 'options');
	$context['about'] = Timber::get_post($about_id);
}

Timber::render('index.twig', $context );
