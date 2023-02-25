<?php 
class Tservice_widget extends WP_Widget {
    public function __construct(){
        parent::__construct(
            'tservice_widget',
            'Service Widget',
            array( 'customize_selective_refresh' => true )
            );
    }

    public function form($instance){
        $defaults = array(
            'title' => '',
            'category' => 'all'
        );

        extract(wp_parse_args( (array) $instance, $defaults)); ?>

        <p> <label for="<?php echo esc_attr($this->get_field_id('title'));?>">Title</label>
        <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title'));?>" 
        name="<?php echo esc_attr($this->get_field_name('title'));?>" value="<?php echo esc_attr($title);?>">
        </p>
       <p><label for="<?php echo esc_attr($this->get_field_id('category'));?>">Service Category</label>
       <select name="<?php echo esc_attr($this->get_field_name('category'));?>" 
       id="<?php echo esc_attr($this->get_field_id('category'));?>" class="widefat">
        <?php 
            $terms = get_terms(array(
                'taxonomy'=> 'service_category',
                'hide_empty'=> false,
            ));

            $options = array(
                'all' => 'All service categories'
            );
            foreach($terms as $term) :
                $options[$term->slug] = $term->name;
            endforeach;

            foreach($options as $key => $name) :
                echo '<option value="'.esc_attr($key).'"'.selected($category, $key, false).'>'.$name.'</option>';
            endforeach;
        ?>
    </select>

       </p>
        <?php 
        }

    public function update($new_instance, $old_instance){
        $instance = $old_instance;
        $instance['title'] = isset($new_instance['title']) ? wp_strip_all_tags($new_instance['title']) : '';
        $instance['category'] = isset($new_instance['category']) ? wp_strip_all_tags($new_instance['category']) : 'all';
        return $instance;
    }
    public function widget ($args, $instance){
        extract($args);

        $title = isset($instance['title']) ? apply_filters('widget_title', $instance['title']) : '';
        $category = isset($instance['category']) ? $instance['category'] : 'all';

         echo $before_widget;
        echo '<div class="wp-widget_tpcatalog">';
        if($title):
            echo $before_title . $title . $after_title;
        endif;

        if($category == 'all') :
            $args = array(
                'post_type' => 'ugyen_services',
                'post_status'=>'publish',
                'orderby' => 'rand',
                'posts_per_page'=> '1'
            );
        else:
            $args = array(
                'post_type' => 'ugyen_services',
                'tax-query' => array(
                    array(
                        'taxonomy'=> 'service_category',
                        'field'=> 'slug',
                        'terms'=> $category
                    )
                ),
                'post_status'=>'publish',
                'orderby' => 'rand',
                'posts_per_page'=> '1'
            );
    
        endif;
        $loop = new WP_Query($args);
        $text ='';
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
            $text ='<p>No Products found.</p>';
        endif;
        wp_reset_postdata();
        echo $text;
        echo '</div>';
        echo $after_widget;
    }
}

function tservice_register_widget(){
    register_widget('Tservice_widget');
}
add_action('widgets_init','tservice_register_widget');
?>