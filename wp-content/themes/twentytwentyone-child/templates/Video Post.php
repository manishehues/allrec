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
  <div class="steptwo">
    <?php 
    $args = array( 'post_type' => 'video', 'posts_per_page' => 10 );
    $the_query = new WP_Query( $args ); 
    ?>
    <?php if ( $the_query->have_posts() ) : ?>
      <div class="allVideos slideVideo">
          <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
        
          <div class="snglVideo">
            <?php the_content(); ?> 
          </div>
        <?php endwhile;?>
      </div>
    <?php wp_reset_postdata(); ?>
    <?php else:  ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
    <?php endif; ?>
  </div>
       

  </div>
  <?php
  get_footer();
