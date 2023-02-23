<?php 
/*
Plugin name: My services
Description: This is the list of services provided by ugyen.
Author: Ugyen Chheda Lama
*/ 
require_once('includes/services-post-type.php');
require_once('includes/service-shortcode.php');
function ugyen_services_setup_menu(){
    add_menu_page('Services', 'Services', 'manage_options', 'ugyen-services', 'service_display_admin_page');
}

function service_display_admin_page(){
    echo '<h1>Services Ugyen Provide</h1>';
    echo '<p>List of services I provide as a WordPress developer. Just add the shortcode to display on the website. [ugyens-services] to show
    all your services or [ugyen-services category="your-category"]</p>';
    echo '<p>We should have widget.</p>';
}
add_action('admin_menu', 'ugyen_services_setup_menu');


?> 