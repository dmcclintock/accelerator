<?php
/*
	Plugin Name: aCC - Dashboard aCCelerator
	Plugin URI: http://www.aCreativeCollective.co
	Description: Custom dashboard branding and reduces unnecessary clutter.
	Version: 2.1.0
	Author: Daniel McClintock
	Author URI: http://about.me/McClintock
	License: GPL2
*/
/*
	Copyright 2014 Daniel McClintock

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// Remove widgets in dashboard
function remove_dashboard_meta() {
	remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' ); // WP News
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // Quick Draft
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); // At a Glance
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal'); // Activity
	remove_action( 'welcome_panel', 'wp_welcome_panel' ); // Welcome
	// remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	// remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	// remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
	// remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	// remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
}
add_action( 'admin_init', 'remove_dashboard_meta' );

// Change footer text (left)
function remove_footer_admin() {
	echo 'Powered by <a href="http://www.acreativecollective.co" target="_blank">aCreativeCollective\'s</a> Dashboard aCCelerator';
}
add_filter('admin_footer_text', 'remove_footer_admin');

// Change footer text (right)
function replace_footer_version() {
	global $current_user;
	get_currentuserinfo();

	echo 'Hello, ';
	echo $current_user->user_firstname;
	echo '.';
}
add_filter( 'update_footer', 'replace_footer_version', '1234');


// Move author meta into publish metabox
function remove_author_post_metabox() { remove_meta_box( 'authordiv', 'post', 'normal' ); }
function remove_author_page_metabox() { remove_meta_box( 'authordiv', 'page', 'normal' ); }
function move_author_to_publish_metabox() {
	global $post_ID;
	$post = get_post( $post_ID );
	echo '<div id="author" class="misc-pub-section" style="border-top-style:solid; border-top-width:1px; border-top-color:#EEEEEE; border-bottom-width:0px;">Author: ';
	post_author_meta_box( $post );
	echo '</div>';
}
add_action( 'admin_menu', 'remove_author_post_metabox' );
add_action( 'admin_menu', 'remove_author_page_metabox' );
add_action( 'post_submitbox_misc_actions', 'move_author_to_publish_metabox' );


/*
   Admin Dashboard Theme
   ========================================================================== */

/**
 * Tuts+: http://j.mp/customWPAdminThemePlugin-tutsPlus
 * GitHub: https://github.com/bilalvirgo10/wp-admin-color-themes
 * SASS:
 * - $ sass color-scheme.scss forest-afternoon.css
 * - $ sass color-scheme-rtl.scss forest-afternoon-rtl.css
 *
 * Official Admin Color Schemes Plugin
 * https://wordpress.org/plugins/admin-color-schemes/
 * Info: http://livingos.com/tweaking-styles-wordpress/
 * See Also: http://www.mattcromwell.com/create-custom-wordpress-admin-color-scheme/
 */


define( 'PATH', plugins_url( '', __FILE__ ) );

function acc_register_dashboard_themes() {

	$suffix = is_rtl() ? '-rtl' : '';

	wp_admin_css_color(
		'accelerator',
		__( 'aCCelerator' ),
		PATH . "/css/accelerator$suffix.css",
		array( '#ececec', '#242424', '#fda623', '#b8b8b8' )
	);
}

add_action( 'admin_init', 'acc_register_dashboard_themes' );





/*
   Reference Code
   ========================================================================== *

global $current_user;
get_currentuserinfo();

if($current_user->user_login != 'accsu') {
echo $current_user->user_firstname;

$site_url = get_bloginfo('url');
echo $site_url;


// Remove "Help" contextual menu
function contextual_help_list_remove() {
	global $current_screen;
	$current_screen->remove_help_tabs();
}
add_filter('contextual_help_list','contextual_help_list_remove');

*/
