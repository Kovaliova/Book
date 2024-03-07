<?php
/**
 * Blogus functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Blogus
 */
add_action('init', function() {
    register_post_type('book', [
		'label' => __('Books', 'txtdomain'),
		'public' => true,
		'supports' => ['title', 'editor', 'thumbnail', 'author', 'revisions', 'comments', 'custom-fields'],
		'show_in_rest' => true,
		'rewrite' => ['slug' => 'book'],
		'taxonomies' => ['book_genre'],
		'labels' => [
			'singular_name' => __('Book', 'txtdomain'),
			'add_new_item' => __('Add new book', 'txtdomain'),
			'new_item' => __('New book', 'txtdomain'),
			'view_item' => __('View book', 'txtdomain'),
			'not_found' => __('No books found', 'txtdomain'),
			'not_found_in_trash' => __('No books found in trash', 'txtdomain'),
			'all_items' => __('All books', 'txtdomain')
		],		
	]);
    register_taxonomy('book_genre', ['book'], [
		'label' => __('Genres', 'txtdomain'),
		'hierarchical' => true,
		'rewrite' => ['slug' => 'book-genre'],
		'show_admin_column' => true,
		'show_in_rest' => true,
		'labels' => [
			'singular_name' => __('Genre', 'txtdomain'),
			'all_items' => __('All Genres', 'txtdomain'),
			'edit_item' => __('Edit Genre', 'txtdomain'),
			'view_item' => __('View Genre', 'txtdomain'),
			'update_item' => __('Update Genre', 'txtdomain'),
			'add_new_item' => __('Add New Genre', 'txtdomain'),
			'new_item_name' => __('New Genre Name', 'txtdomain'),
			'search_items' => __('Search Genres', 'txtdomain'),
			'not_found' => __('No Genres found', 'txtdomain'),
		]
	]);
	register_taxonomy_for_object_type('book_genre', 'book');
});


add_action( 'wp_enqueue_scripts', 'filter_jquery_scripts' );
 
function filter_jquery_scripts() {
 
	wp_enqueue_script( 'jquery' );
 
	wp_register_script( 'filter', get_stylesheet_directory_uri() . '/js/filter.js', array( 'jquery' ), time(), true );
	wp_enqueue_script( 'filter' );
 
	wp_localize_script( 'filter', 'true_obj', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

}


add_action( 'wp_ajax_myfilter', 'filter_function' );
add_action( 'wp_ajax_nopriv_myfilter', 'filter_function' );

function filter_function(){
	get_template_part("item-post");

	die();
}

   