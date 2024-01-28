<?php
/*
   Plugin Name: Accrediblecertificate Plugin
   Plugin URI: https://tatsiana-dev.eu
   Description: first plugin
   Version: 1.0.0
   Author: Tatsiana Dev
   Author URI: https://tatsiana-dev.eu
*/

function accrediblecertificate_table() {

    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $tablename = $wpdb->prefix . "accrediblecertificate";

    $sql = "
		CREATE TABLE IF NOT EXISTS $tablename (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `user_id` int(10) unsigned NOT NULL,
		  `group_id` int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'ID Accredible Group',
		  `created` datetime NOT NULL,
		  `url_image` varchar(255) DEFAULT NULL,
		  `url_badge` varchar(255) DEFAULT NULL,
		  `created` datetime NOT NULL,
		  `published` tinyint NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`),
		  KEY `id_user` (`id_user`),
		  KEY `group_id` (`group_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'accrediblecertificate_table');

function accrediblecertificate_menu() {
    add_menu_page("Accredible Credentials", "Accredible Credentials", "manage_options", "accrediblecertificate", "displayList", "dashicons-admin-page");
    add_submenu_page("accrediblecertificate", "Accredible Credentials", "Accredible Credentials", "manage_options", "allentries", "displayList");
    remove_submenu_page('accrediblecertificate','accrediblecertificate');
}

add_action("admin_menu", "accrediblecertificate_menu");
add_action( 'user_register', "acc_register_new_user_action");

function displayList() {
    include "displaylist.php";
}

function acc_register_new_user_action( $user_id ) {

	require_once "api.php";
	global $wpdb;
	
	$default_group_id = '546130';
	$user = get_user_by( 'ID', $user_id );
	
	$api = new api('ade377f959a7f522c67a948772f02bc6', true);
	$new_credential = $api->create_credential($user->user_nicename, $user->user_email, $default_group_id);

	$wpdb->query( $wpdb->prepare( "INSERT INTO `wp_accrediblecertificate` ( user_id, group_id, url_image, url_badge, created, published ) VALUES (%s, %s, %s, %s, %s, %s)", $user_id, $default_group_id, $new_credential['credential']['seo_image'], $new_credential['credential']['badge']['image']['preview'], date('Y-m-d H:i:s'), ( !empty($new_credential['credential']['seo_image']) ? 1 : 0 )));
}
