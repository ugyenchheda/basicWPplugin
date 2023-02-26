<?php 
/*
Plugin name: My services
Description: This is the list of services provided by ugyen.
Author: Ugyen Chheda Lama
*/ 
require_once('includes/services-post-type.php');
require_once('includes/service-shortcode.php');
require_once('includes/service-widget.php');
function ugyen_services_setup_menu(){
    add_menu_page('Services', 'Services', 'manage_options', 'ugyen-services', 'service_display_admin_page');
}

function service_display_admin_page(){
    echo '<h1>Add Services </h1>';
    echo '<p>List of services available and can be displayed using shortcode [ugyens-services] to show
    all your services or [ugyen-services category="your-category"]</p>';
    echo '<p>We should have widget. This is just a first stage plugin, it will be updated on the weekly basis. </p>';
}
add_action('admin_menu', 'ugyen_services_setup_menu');

function services_assets(){
    wp_enqueue_style('service-css', plugin_dir_url(__FILE__).'includes/css/service.css');
}
add_action('wp_enqueue_scripts', 'services_assets');
?> 