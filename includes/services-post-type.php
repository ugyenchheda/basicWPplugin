<?php
    function services_register_post_type(){
        add_theme_support('post-thumbnails');

        $labels =array (
            'name' => 'My Services',
            'singular_name' => 'Service',
            'add_new' => 'New Service',
            'add_new_item' => 'Add New Service',
            'edit_item' => 'Edit Service',
            'view_item' => 'View Service',
            'search_items'=> 'Search Services',
            'not_found' => 'No Services Found',
            'not_found_in_trash' => 'No Services found in Trash'
        );

        $args = array(
            'labels' => $labels,
            'has_archive' => true,
            'public' => true,
            'hierarchical' => false,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail',
                'custom-fields'
            ),
            'rewrite' => array('slug' => 'my-service'),
            'show_in_rest' => true
        );
        register_post_type('ugyen_services', $args);
    }
    add_action('init','services_register_post_type');

    /* Add price box */

    function service_add_custom_box(){
        add_meta_box(
            'service_price_id',
            'Price',
            'service_price_html',
            'ugyen_services',
        );
    }
    function service_price_html($post){
        $value = get_post_meta($post->ID, '_service_meta_price', true);
        ?>
        <label for ="service_price">Price</label>
        <input type="text" name="service_price" id="service_price" value="<?php echo $value; ?>">
        <?php
    }
    add_action('add_meta_boxes','service_add_custom_box' );
    /* save post meta*/
    function service_save_postdata($post_id){
        if(array_key_exists('service_price', $_POST)){
            update_post_meta(
                $post_id,
                '_service_meta_price',
                sanitize_text_field($_POST['service_price'])
            );
        }
    }
    add_action('save_post','service_save_postdata');

    /* register new taxonomy (services)*/
    function service_register_taxonomy() {
        $labels = array(
            'name'=> 'Service Categories',
            'singular_name'=> 'Service Category',
            'search_items'=> 'Search Service Categories',
            'all_items' => 'All Service Categories',
            'edit_item' => 'Edit Service Categories',
            'update_item'=> 'Update Service Categories',
            'add_new_item'=>'Add New Service Category',
            'new_item_name'=> 'New Service Category Name',
            'menu_name'=> 'Service Categories'
        );
        $args = array(
            'labels' =>$labels,
            'hierarchical' => true,
            'sort'=> true,
            'args'=> array('orderby'=>'term_order'),
            'rewrite'=> array('slugs'=>'services'),
            'show_admin_column'=> true,
            'show_in_rest'=>true
        );
        
        register_taxonomy('service_category', array('ugyen_services'), $args);
    }
    add_action('init', 'service_register_taxonomy');
?>