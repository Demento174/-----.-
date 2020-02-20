<?php
/*
Template Name: Главная
*/

$context = Timber::get_context();
$context['options'] = get_fields('options');
$context['terms']= get_terms([
	'taxonomy'=>'tax_dish',
	'orderby'   => 'meta_value', //or 'meta_value_num'
	'meta_key' => 'order'

]);

get_header();
Timber::render('title.twig',$context);
Timber::render('content.twig',$context);
Timber::render('bottom.twig',$context);
Timber::render('modal.twig',$context);
get_footer();

?>
