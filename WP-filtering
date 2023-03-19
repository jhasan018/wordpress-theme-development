//Your HTML file
<section>
    <div class="container">
        <div class="row categories">
            <div class="col-md-12">
                <select class="filter-select">
                    <option value="" class="filter-item">All</option>
                    <?php
                    $cat_args = array(
                        'exclude' => array(1),
                        'option_all' => 'all'
                    );
                    $categories = get_categories($cat_args);

                    foreach($categories as $cat):?>
                        <option value="<?php echo $cat->term_id;?>" class="filter-item">
                            <?php echo $cat->name; ?>
                        </option>
                    <?php endforeach;
                    ?>
                </select>             
            </div>
        </div>
        <div class="row filtering">
            <?php
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => -1
                );

                $query = new WP_Query($args);

                if($query -> have_posts()) :
                while($query -> have_posts()) : $query-> the_post();?>
                <div class="col-sm-3">
                    <div class="content">
                        <img src="" alt=""><?php the_post_thumbnail('medium'); ?></img>
                    </div>
                    <h5><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>                   
                </div>
                <?php endwhile;
                endif;
                wp_reset_postdata();
                ?>       
        </div>      
    </div>
</section>



//add this in function.php

<?php
/*
* Enqueue custom_filter.js if file custom_filter.js exists
*/

function load_scripts(){
    wp_enqueue_script('ajax', get_template_directory_uri(). "/assets/js/custom_filter.js",array('jquery'),NULL,true);

    wp_localize_script('ajax','wpAjax',
        array('ajaxUrl' => admin_url('admin-ajax.php'))
    );
}

add_action('wp_enqueue_scripts','load_scripts');
?>


<?php


add_action('wp_ajax_nopriv_filter','filter_ajax');
add_action('wp_ajax_filter','filter_ajax');

function filter_ajax(){

    $category = $_POST['category'];

    $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => -1
                );

                if($category !== '') {
                    $args['category__in'] = array($category);
                }

                $query = new WP_Query($args);

                if($query -> have_posts()) :
                while($query -> have_posts()) : $query-> the_post();?>
                <div class="col-sm-3">
                    <div class="content">
                        <img src="" alt=""><?php the_post_thumbnail('medium'); ?></img>
                    </div>
                    <h5><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>                   
                </div>
                <?php endwhile;
                endif;
                wp_reset_postdata();


    die();
}
?>
 
//add this on your javascript file custom_filter.js

<script>
  (function($){

    $(document).ready(function(){
        $(document).on('change','.filter-select',function(e){
            e.preventDefault();

            var category = $(this).val();

            $.ajax({
                url: wpAjax.ajaxUrl,
                data: {action: 'filter', category: category},
                type: 'post',
                success: function(result){
                    $('.filtering').html(result);
                },
                error: function(result){
                    console.warn(result);
                }
            });
        });
    });


})(jQuery);

</script>
