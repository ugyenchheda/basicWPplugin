<?php
function service_shortcode($serv_attr){
    $default = array(
        'category'=>'all',
    );
    $cat = shortcode_atts($default, $serv_attr);

    if($cat['category'] == 'all') :
        $args = array(
            'post_type' => 'ugyen_services',
            'post_status'=>'publish',
            'orderby' => 'title',
            'order' => 'ASC',
        );
    else:
        $args = array(
            'post_type' => 'ugyen_services',
            'tax-query' => array(
                array(
                    'taxonomy'=> 'service_category',
                    'field'=> 'slug',
                    'terms'=> $cat['category']
                )
            ),
            'post_status'=>'publish',
            'orderby' => 'title',
            'order' => 'ASC',
        );

    endif;
    $loop = new WP_Query($args);
    $text ='<div class="tiny-product-catalog">';
    if($loop->have_posts()) :
        while($loop->have_posts()) : $loop->the_post();
            $price=get_post_meta(get_the_ID(), '_service_meta_price', true);
            $text .= '<section class="tiny-product"><h3>'. get_the_title(). '</h3>';
            $text .= '<p class="my-price">Just for € '.$price. '</p>';
            $text .= get_the_post_thumbnail();
            $text .= get_the_content();
            $text .=  '<p class="more-link"><a href="'.get_the_permalink().'" class="read-more">Read More</a></p></section>';
    endwhile;
    else:
        $text ='<p>N Products found.</p>';
    endif;
    $text .='</div>';
    wp_reset_postdata();
    return $text;
}
add_shortcode('ugyens-services', 'service_shortcode');
?>