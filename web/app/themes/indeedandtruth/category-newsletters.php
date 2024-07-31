<?php

$context = Timber::context();

$context['title'] = 'Newsletter Archives';
$context['posts'] = Timber::get_posts(array(
    'posts_per_page' => -1,
    'category_name' => 'newsletters'
));

Timber::render('category-newsletters.twig', $context );
