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
            <div class="commentForm">
                <div class="userComments">
                    <div class="foruserScrool">
                        <ul>
                        <li class="profile_single">
                            <div class="user"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user.png"/>Usernamea
                                <span>Love this!!❤️❤️❤️</span>
                                <div class="likes">
                                    <span class="time">1h - </span><span class="likes">21 </span><span class="likesText">likes - </span><span class="reply">Reply</span>
                                </div>
                            </div>
                        </li>
                        <li class="profile_single">
                            <div class="user"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user.png"/>Usernamea
                                <span>Love this!!❤️❤️❤️</span>
                                <div class="likes">
                                    <span class="time">1h - </span><span class="likes">21 </span><span class="likesText">likes - </span><span class="reply">Reply</span>
                                </div>
                            </div>
                        </li>
                        <li class="profile_single">
                            <div class="user"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user.png"/>Usernamea
                                <span>Love this!!❤️❤️❤️</span>
                                <div class="likes">
                                    <span class="time">1h - </span><span class="likes">21 </span><span class="likesText">likes - </span><span class="reply">Reply</span>
                                </div>
                            </div>
                        </li>
                        <li class="profile_single">
                            <div class="user"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user.png"/>Usernamea
                                <span>Love this!!❤️❤️❤️</span>
                                <div class="likes">
                                    <span class="time">1h - </span><span class="likes">21 </span><span class="likesText">likes - </span><span class="reply">Reply</span>
                                </div>
                            </div>
                        </li>
                        <li class="profile_single">
                            <div class="user"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user.png"/>Usernamea
                                <span>Love this!!❤️❤️❤️</span>
                                <div class="likes">
                                    <span class="time">1h - </span><span class="likes">21 </span><span class="likesText">likes - </span><span class="reply">Reply</span>
                                </div>
                            </div>
                        </li>
                        <li class="profile_single">
                            <div class="user"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user.png"/>Usernamea
                                <span>Love this!!❤️❤️❤️</span>
                                <div class="likes">
                                    <span class="time">1h - </span><span class="likes">21 </span><span class="likesText">likes - </span><span class="reply">Reply</span>
                                </div>
                            </div>
                        </li>
                        <li class="profile_single">
                            <div class="user"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user.png"/>Usernamea
                                <span>Love this!!❤️❤️❤️</span>
                                <div class="likes">
                                    <span class="time">1h - </span><span class="likes">21 </span><span class="likesText">likes - </span><span class="reply">Reply</span>
                                </div>
                            </div>
                        </li>
                        <li class="profile_single">
                            <div class="user"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user.png"/>Usernamea
                                <span>Love this!!❤️❤️❤️</span>
                                <div class="likes">
                                    <span class="time">1h - </span><span class="likes">21 </span><span class="likesText">likes - </span><span class="reply">Reply</span>
                                </div>
                            </div>
                        </li>
                        <li class="profile_single">
                            <div class="user"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user.png"/>Usernamea
                                <span>Love this!!❤️❤️❤️</span>
                                <div class="likes">
                                    <span class="time">1h - </span><span class="likes">21 </span><span class="likesText">likes - </span><span class="reply">Reply</span>
                                </div>
                            </div>
                        </li>
                        <li class="profile_single">
                            <div class="user"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user.png"/>Usernamea
                                <div class="replyComment">
                                Usernamea
                                    <div class="reply">
                                      <span>mam this month i am very busy....... because of office projects you'll.</span>
                                    </div>
                                </div>
                                <span>Love this!!❤️❤️❤️</span>
                                <div class="likes">
                                    <span class="time">1h - </span><span class="likes">21 </span><span class="likesText">likes - </span><span class="reply">Reply</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                    </div>
                    
                    <div class="formFeild">
                        <form action="/action_page.php">
                            <textarea id="w3review" name="w3review" rows="4" cols="50">Add Comments</textarea>
                            <input type="submit" value="Post" class="userComments">
                        </form>
                    </div>
                </div>
            </div>
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