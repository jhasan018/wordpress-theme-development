
<?php
add_action( 'wp_footer', 'my_work_javascript' );

function my_work_javascript() { ?>
	<script type="text/javascript" >
	jQuery(document).ready(function($) {
        var page_count1 = '<?php echo ceil(wp_count_posts('post')->publish / 2 ); ?>';
        console.log(page_count1);
        var ajaxurl = '<?php echo admin_url("admin-ajax.php");?>';
        var page = 2 ;
        jQuery('#loadmore').click(function(){
            var data = {
			'action': 'my_work_action',
			'page': page,
		};
		jQuery.post(ajaxurl, data, function(response) {
            jQuery('#post-container').append(response);
            if(page_count1 == page){
                jQuery('#loadmore').hide();
            }
            page = page + 1;
		});

    });
		
	});
	</script> <?php
}

add_action( 'wp_ajax_my_work_action', 'my_work_action' );
add_action( 'wp_ajax_nopriv_my_work_action', 'my_work_action' );

function my_work_action() {
	$args = array(
                'post_type' => 'work',
                'post_status' => 'publish',
                'posts_per_page' => 2,
                'paged' => $_POST['page']
            );
            
            // The Query
            $query = new WP_Query( $args );

            // The Loop
            if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>

                    <div class="col-sm-6 col-md-6">
                        <div class="portfolio-item">
                            <?php the_post_thumbnail('large');?>
                            <div class="portfolio-details">
                                <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                                <a href="<?php echo get_post_meta($query->ID,'sub_title',true); ?>">Accounts</a>
                            </div>
                        </div>
                    </div>
                    
                    <?php wp_reset_postdata();?>              
                <?php endwhile; ?>
				<?php endif;?> 

	<?php wp_die();
}