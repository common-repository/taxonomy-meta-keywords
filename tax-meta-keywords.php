<?php
/*
Plugin Name: Taxonomy Meta Keywords
Plugin URI: http://blog.roaway.com
Version: v1.00
Author: Roaway
Description: A sample plugin for a Meta Keywords.
*/


class tax_meta_keywords{
	
	function tax_meta_keywords(){
		add_action('init', array($this,'keywords_init'));
		add_action('wp_head', array($this,'add_keywords_tag'));

	}
	

	
	function keywords_init() {
		if ( function_exists('load_plugin_textdomain') ) {
			load_plugin_textdomain('tax-meta-keywords', false, dirname( plugin_basename(__FILE__) ) );
		}
		
		// Add new taxonomy, NOT hierarchical (like tags)
		$labels = array(
		'name' => _x( 'Keywords', 'tax-meta-keywords'),
		'singular_name' => _x( 'Keyword', 'tax-meta-keywords'),
		'search_items' =>  __( 'Search Keywords' , 'tax-meta-keywords'),
		'popular_items' => __( 'Popular Keywords' , 'tax-meta-keywords'),
		'all_items' => __( 'All Keywords', 'tax-meta-keywords' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit Keyword', 'tax-meta-keywords' ), 
		'update_item' => __( 'Update Keyword', 'tax-meta-keywords' ),
		'add_new_item' => __( 'Add New Keyword', 'tax-meta-keywords' ),
		'new_item_name' => __( 'New Keyword Name', 'tax-meta-keywords' ),
		'separate_items_with_commas' => __( 'Separate Keywords with commas', 'tax-meta-keywords' ),
		'add_or_remove_items' => __( 'Add or remove Keywords', 'tax-meta-keywords' ),
		'choose_from_most_used' => __( 'Choose from the most used Keywords', 'tax-meta-keywords' ),
		'menu_name' => __( 'Keywords', 'tax-meta-keywords'),
		); 	

		
		register_taxonomy("tax-meta-keywords", 
		array('page','post', 'custom_post_type'),
		array(
		'hierarchical' => false,
		'labels' => $labels,
		'show_ui' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
		'rewrite' => array( 'slug' => 'keyword' ))
		);
	}
	
	
	
	function add_keywords_tag(){
		if(is_single()){
			$tags = get_the_terms($post->ID, 'tax-meta-keywords');
			if(empty($tags)){
				$tags = get_the_tags($post->ID);
			}
			if(empty($tags)){
				$tags = get_the_title($post->ID);
			}
		}
		if(empty($tags)){
			$tags = bloginfo('description');
		}
		
		if ( !empty($tags) && is_array($tags) ){
			foreach ($tags as $tag) {
				$keywords[count($keywords)] = $tag->name;
			}
			echo '<meta name="keywords" content="'.implode(" ", $keywords).'" />'."\n";
		}
		else if (!empty($tags)){
			echo '<meta name="keywords" content="'.$tags.'" />'."\n";
		}
	}
	
}
$meta_keywords = new tax_meta_keywords();
?>
