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

    //pr($the_query);
    ?>
    <?php if ($the_query->have_posts()) : ?>
      <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
        <div class="giveAway-product">
          <div class="Sap">
            <?php the_post_thumbnail(); ?>
            <div class="cart_tittle">
              <h2><?php the_title(); ?></h2>

              <?php $res = check_user_participation(get_the_ID());
              if ($res > 0) : ?>
                <a href="javascript:void(0)" class="btn btn-primary ">Already Participat</a>

              <?php else : ?>

                <a href="javascript:void(0)" class="btn btn-primary add_participants " data-bs-toggle="modal" data-bs-target="#myModal" data-post-id="<?php echo  get_the_ID(); ?>">Add to cart</a>

              <?php endif ?>

            </div>
            <div class="lottryNumber">
              Raffle Draw <br><?php echo check_total_participant_per_post(get_the_ID()) ?>/<?php the_field('total_participants'); ?>
            </div>
          </div>


          <?php the_content(); ?>
          <div class="giveAway-chatbox">
            <div class="commentForm">
              <div class="userComments">
                <div class="foruserScrool">
                  <div id="respond<?php echo  get_the_ID(); ?>" class="comment-respond">
                    <?php $comments = get_comments(array('post_id' => get_the_ID(), 'order' => 'ASC')); ?>
                    <ul class="commentslist">

                      <?php

                      //pr($comments);

                      if ($comments) :
                        foreach ($comments as $key => $comment) { ?>

                          <li class="profile_single" id="comment-<?php echo $comment->comment_ID ?>">
                            <div class="user">
                              <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user.png" />
                              <?php echo $comment->comment_author ?>

                              <?php $reply_comment = check_reply_parent_cmnt_id($comment->comment_parent);
                              ?>

                              <?php if (!empty($reply_comment)) : ?>
                                <div class="replyComment">
                                  <?php echo $reply_comment->comment_author ?>
                                  <div class="reply">
                                    <span><?php echo str_limit($reply_comment->comment_content, 20) ?></span>
                                  </div>
                                </div>
                              <?php endif ?>

                              <span><?php echo $comment->comment_content ?></span>
                              <div id="respond"></div>
                              <div class="likes">
                                <span class="time "><?php echo time_elapsed_string($comment->comment_date); ?> - </span>

                                <span class="time like-comment" rel="<?php echo $comment->comment_ID ?>"> likes <span class="likes"><?php echo $comment->cmnt_like ?></span>
                                </span>

                                <span class="reply comment-reply-link" data-post_id="<?php echo  get_the_ID() ?>" rel="<?php echo $comment->comment_ID ?>" data-reply="<?php echo $comment->comment_author ?>" data-str="<?php echo $comment->comment_content ?>">Reply</span>
                              </div>
                          </li>
                      <?php }
                      endif; ?>


                      <!-- <li class="profile_single">
                        <div class="user"><img src="<?php //echo get_stylesheet_directory_uri() 
                                                    ?>/assets/images/user.png" />Usernamea
                          <div class="replyComment">
                            Usernamea
                            <div class="reply">
                              <span>mam this month i am very busy....... because of office projects you'll.</span>
                            </div>
                          </div>
                          <span>Love this!!❤️❤️❤️</span>
                          <div class="likes">
                            <span class="time">1h - </span>likes<span class="likes">
                            </span>
                            <span class="likesText">likes - </span><span class="reply">Reply</span>
                          </div>
                        </div>
                      </li> -->



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


  <div class="modal fade show" id="myModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Participant</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">


          <?php $total_tickets = get_all_tickets(); ?>
          <select name="current_number" class="ticket_number">
            <option value="">Select Ticket</option>
            <?php
            foreach ($total_tickets as $ticket) {
              echo '<option value="' . $ticket->total_tickets . '" >' . $ticket->total_tickets . '</option>';
            }
            ?>
          </select>

          <input type="hidden" name="comment_post_ID" class="current_post_id" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary participant">Participant</button>
        </div>
      </div>
    </div>
  </div>
  <?php
  get_footer();
