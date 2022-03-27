<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt Disable Non-Core Blocks in Posts
 * Plugin URI:        https://www.kntnt.com/
 * Description:       Disables all but core blocks in posts.
 * Version:           1.0.0
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */


defined( 'ABSPATH' ) || die;

add_filter( 'allowed_block_types_all', function ( $allowed_blocks, $block_editor_context ) {
	if ( ! empty( $block_editor_context->post ) && 'post' == $block_editor_context->post->post_type ) {
		if ( $allowed_blocks === true ) {
			$allowed_blocks = array_keys( WP_Block_Type_Registry::get_instance()->get_all_registered() );
		}
		$allowed_blocks = array_filter( $allowed_blocks, function ( $type ) {
			return strncmp( $type, 'core/', 5 ) == 0;
		} );
		$allowed_blocks = array_values( $allowed_blocks ); // WordPress requires reindexing.
	}
	return $allowed_blocks;
}, 10, 2 );
