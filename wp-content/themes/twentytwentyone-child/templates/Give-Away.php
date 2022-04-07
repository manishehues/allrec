<?php
/**
 * Template Name: Give Away
 *
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
?>

<div class="container">
    <div class="giveAway">
            <?php 
        $args = array( 'post_type' => 'give_away', 'posts_per_page' => 10 );
        $the_query = new WP_Query( $args ); 
    ?>
        <?php if ( $the_query->have_posts() ) : ?>
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
        
            <div class="giveAway-product">
                <div class="Sap">
                    <?php the_post_thumbnail(); ?>
                    <div class="cart_tittle">
                        <h2><?php the_title(); ?></h2>
                        <a href="#"  class="button product_type_simple add_to_cart_button ajax_add_to_cart giveAwaybutton">Add to cart</a>
                    </div>
                    <div class="lottryNumber">
                        Raffle Draw <br>488/<?php the_field('total_participants'); ?>
                    </div>
                    
                </div>
                
                <?php the_content(); ?> 
                
                <div class="giveAway-chatbox">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_box.svg"/> 
                </div>
            </div>

        <?php endwhile;
            wp_reset_postdata(); ?>
        <?php else:  ?>
            <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
        <?php endif; ?>
    </div>
</div>



<?php
get_footer();
