<?php

/**
 * Template Name: Eventes
 *
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
?>


<div class="container">
  <div class="ticket_tittle">
    <div class="tittle">
      <div class="content">
        <h1><span>EVENTS</span></h1>
        <p>Come join us at these events and have some fun!</p>
      </div>
    </div>
</div>
<?php while (have_posts()) : the_post(); ?>
<?php
    $args = array('post_type' => 'event_post', 'posts_per_page' => 10);
    $the_query = new WP_Query($args);
    ?>
    <?php if ($the_query->have_posts()) : ?>
      <?php while ($the_query->have_posts()) : $the_query->the_post();?>
     <?php if ( has_post_thumbnail()) : ?>
      <div class="eventPost">
        <div class="eventImage">
          <?php the_post_thumbnail(); ?>
        </div>
        <div class="eventContent">
          <div class="innerContent">
            <div class="tittleevent"><?php echo the_title(); ?></div>
            <p><!-- Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, -->
            <?php the_field('discription'); ?></p>
            <div class="winner">
              <!-- WINNER: Jhone QUE --><?php the_field('winner'); ?>
            </div>
            <div class="Hours">
              <div class="hourTittle"><?php the_field('hours_tittle'); ?><!-- Hours --></div>
              <?php the_field('date_and_time'); ?>
             <!-- Monday-02 -2022 : 07 PM - 10 AM<br>
             Monday-02 -2022 : 07 PM - 10 AM -->
            </div>
            <div class="guest">
              <!-- Number Of Guest: 04 --><?php the_field('number_of_guest'); ?>
            </div>
            <div class="winnerlast">
              <?php the_field('how_to_win'); ?>
              <!-- How to win: -->
              <p><!-- Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, --><?php the_field('win_discription'); ?></p>
            </div>
          </div>
        </div>
      </div>
    </a>
<?php endif; ?>
        <?php endwhile;
        wp_reset_postdata(); ?>
    <?php else :  ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>
<?php
endwhile;
?>

  <?php
  get_footer();
