<?php

/**
 * Template Name: Video post
 *
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
?>


<div class="container">

  <div class="onlytest">
    <?php 
    $args = array( 'post_type' => 'video', 'posts_per_page' => 1 );
    $the_query = new WP_Query( $args ); 
    ?>
    <?php if ( $the_query->have_posts() ) : ?>
    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
    <!-- <h2><?php the_title(); ?></h2> -->
    <div class="entry-content">
    <?php the_content(); ?> 
    </div>
    <?php endwhile;
    wp_reset_postdata(); ?>
    <?php else:  ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
    <?php endif; ?>
  </div>

  <div class="product">
        <div class="productTitle">
            <div class="setTitel">
                <h2>SHOP</h2>
                <p>Subscribe to our foundation and get membership to exclusive<br>perks such as: Event, Prizes, apparel, food, vacations, cannabis<br>and much more.</p>
            </div>
            <div class="sildeSlider">
            </div>
        </div>
        <div class="steptwo">
          <?php 
          $args = array( 'post_type' => 'video', 'posts_per_page' => 10 );
          $the_query = new WP_Query( $args ); 
          ?>
          <!-- <?php if ( $the_query->have_posts() ) : ?> -->
          <?php the_post_thumbnail(); ?>


            <div class="allVideos slideVideo">
                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>  
                <a href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>">      
                <div class="snglVideo">
                  <!-- <?php the_content(); ?>  -->
                  <?php the_post_thumbnail(); ?>

                </div>
              </a>
              <?php endwhile;?>
            </div>
          <?php wp_reset_postdata(); ?>
          <?php else:  ?>
          <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
          <?php endif; ?>
      </div>
  </div>
  
       

  </div>
  <?php
  get_footer();
