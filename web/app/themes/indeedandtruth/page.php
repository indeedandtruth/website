<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/templates/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();

$timber_post     = Timber::get_post();
$context['post'] = $timber_post;
$context['gradient'] = false;
$children = array(
    'child_of' => $timber_post->ID,
);
$context['children'] = Timber::get_pages_menu($children);
$context['comments_template'] = comments_open() || get_comments_number();
if(class_exists('ACF')) {
    $context['gradient'] = get_field('gradient_overlay', $timber_post->ID);
    $context['hide_featured'] = get_field('hide_featured', $timber_post->ID);
}
Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page.twig' ), $context );
