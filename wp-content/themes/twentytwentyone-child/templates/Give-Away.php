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
  <div class="ticket_tittle">
    <div class="tittle">
      <div class="content">
        <h1>GIVE <span>AWAYS</span></h1>
        <p>Once the prize reaches its goal, a raffle will be drawn and a winner will be announced</p>
      </div>
    </div>
    <div class="ticket">
      <h6><?php echo $total_tickets_count = get_all_tickets_of_current_user(); ?></h6>
      <p>Available Tickets</p>
    </div>

  </div>
  <div class="giveAway">
    <?php
    $args = array('post_type' => 'give_away', 'posts_per_page' => 10);
    $the_query = new WP_Query($args);

    ?>
    <?php if ($the_query->have_posts()) : ?>
      <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
        <div class="giveAway-product">
          <div class="Sap">
            <?php the_post_thumbnail(); ?>
            <div class="cart_tittle">
              <h2><?php the_title(); ?></h2>
              <a href="#" class="button product_type_simple add_to_cart_button ajax_add_to_cart giveAwaybutton">Add to cart</a>
            </div>
            <div class="lottryNumber">
              Raffle Draw <br>488/<?php the_field('total_participants'); ?>
            </div>
          </div>

          <div>
            <?php
            $total_tickets = get_all_tickets();
            /* echo "<pre>";
            print_r($total_tickets); */
            ?>
            <select name="current_number">
              <option value="">Select Ticket</option>

              <?php
              foreach ($total_tickets as $ticket) {
                //echo $ticket;
                echo '<option value="' . $ticket->id . '" >' . $ticket->total_tickets . '</option>';
              }
              ?>
              <!-- <option value="10">10</option>
              <option value="20">20</option>
              <option value="40">40</option>
              <option value="60">60</option>
              <option value="100">100</option>
              <option value="200">200</option> -->
            </select>
          </div>

          <?php the_content(); ?>
          <div class="giveAway-chatbox">
            <div class="commentForm">
              <div class="userComments">
                <div class="foruserScrool">
                  <div id="respond<?php echo  get_the_ID(); ?>" class="comment-respond">
                    <?php $comments = get_comments(array('post_id' => get_the_ID(), 'order' => 'ASC')); ?>
                    <ul class="commentslist">
                      <?php if ($comments) :
                        foreach ($comments as $key => $comment) { ?>

                          <li class="profile_single" id="comment-<?php echo $comment->comment_ID ?>">
                            <div class="user">
                              <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user.png" />
                              <?php echo $comment->comment_author ?>
                              <span><?php echo $comment->comment_content ?></span>
                              <div id="respond"></div>
                              <div class="likes">
                                <span class="time ">1h - </span>

                                <span class="time like-comment" rel="<?php echo $comment->comment_ID ?>"> likes <span class="likes"><?php echo $comment->cmnt_like ?></span>
                                </span>

                                <span class="reply comment-reply-link" data-post_id="<?php echo  get_the_ID() ?>" rel="<?php echo $comment->comment_ID ?>">Reply</span>
                              </div>
                          </li>

                          <!-- <li class="profile_single" >
                          <div class="user"><img src="<?php //echo get_stylesheet_directory_uri() 
                                                      ?>/assets/images/user.png" />Usernamea
                            <div class="replyComment">
                              Usernamea
                              <div class="reply">
                                <span>mam this month i am very busy....... because of office projects you'll.</span>
                              </div>
                            </div>
                            <span>Love this!!❤️❤️❤️</span>
                            <div class="likes" >
                              <span class="time">1h - </span>likes<span class="likes">
                              </span>
                              <span class="likesText">likes - </span><span class="reply">Reply</span>
                            </div>
                          </div>
                        </li> -->
                      <?php }
                      endif; ?>
                    </ul>
                  </div>
                </div>

                <div class="formFeild">
                  <form action="http://localhost/allrec/wp-comments-post.php" method="post" id="commentform_<?php echo  get_the_ID(); ?>" class="comment-form" rel="<?php echo  get_the_ID(); ?>" novalidate="">
                    <textarea name="comment" id="comment_<?php echo  get_the_ID(); ?>" name="w3review" rows="4" cols="50" required="required" placeholder="Add Comments"></textarea>
                    <input type="button" value="Post" class=" postComment userComments" rel="<?php echo  get_the_ID(); ?>" id="submit<?php echo  get_the_ID(); ?>">
                    <input type="hidden" name="comment_post_ID" value="<?php echo  get_the_ID(); ?>" id="comment_post_ID">
                    <input type="hidden" name="comment_parent" id="comment_parent_<?php echo  get_the_ID(); ?>" value="">
                  </form>
                </div>
              </div>
            </div>

          </div>
        <?php endwhile;
      wp_reset_postdata(); ?>
      <?php else :  ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
      <?php endif; ?>
        </div>

  </div>
  <?php
  get_footer();
