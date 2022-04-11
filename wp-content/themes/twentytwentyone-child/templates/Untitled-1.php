<!--  <div id="respond<?php //echo  get_the_ID(); 
                        ?>" class="comment-respond">

              <?php //$comments = get_comments(array('post_id' => get_the_ID(), 'order' => 'ASC')); 
                ?>
              <ul class="commentslist">

                <?php //if ($comments) :

                //foreach ($comments as $key => $comment) { 
                ?>

                    <li id="comment-<?php //echo //$comment->comment_ID; 
                                    ?>">

                      <article class="comment byuser comment-author-admin bypostauthor even thread-even depth-1 entry-comments">
                        <div class="comment-avatar">
                          <img alt="" src="http://2.gravatar.com/avatar/5de4a6139cc0576a70e0dfa51dbb5a8d?s=75&d=mm&r=g" class="avatar arm_grid_avatar arm-avatar avatar-75 photo" height="75" width="75" loading="lazy">
                        </div>
                        <div class="comment-content">
                          <h3 class="comment-author">
                            <span class="url"><?php //echo $comment->comment_author 
                                                ?></span>
                          </h3>
                          <div class="comment-meta">
                            <?php //echo sprintf('%1$s at %2$s', get_comment_date(),  get_comment_time()) 
                            ?>
                          </div>
                          <ol class="comment-list">
                            <li id="comment-1" class="comment depth-1">
                              <article>

                                <div class="commentLike">
                                  <span rel="<?php //echo $comment->comment_ID; 
                                                ?>" class="like-comment">like
                                    <?php //if ($comment->cmnt_like > 0) {
                                    // echo $comment->cmnt_like;
                                    // }
                                    ?> </span>
                                </div>

                                <div class="reply">
                                  <a data-post_id="<?php //echo  get_the_ID(); 
                                                    ?>" rel="<?php //echo $comment->comment_ID; 
                                                                ?>" class="comment-reply-link">Reply</a>
                                </div>
                              </article>
                              <ol class="children"></ol>
                            </li>
                          </ol>
                          <div id="respond"></div>
                          <div class="comment-text">
                            <p><?php //echo $comment->comment_content 
                                ?></p>
                          </div>
                        </div>

                      </article>

                    </li>
                <?php //}
                //endif; 
                ?>
              </ul>
              <form action="http://localhost/allrec/wp-comments-post.php" method="post" id="commentform_<?php echo  get_the_ID(); ?>" class="comment-form" rel="<?php echo  get_the_ID(); ?>" novalidate="">
                <p class="comment-form-comment">
                  <label for="comment">Comment</label>
                  <textarea name="comment" id="comment_<?php echo  get_the_ID(); ?>" cols="45" rows="8" required="required"></textarea>
                </p>

                <p class="form-submit">

                  <input name="submit" type="button" rel="<?php echo  get_the_ID(); ?>" id="submit<?php echo  get_the_ID(); ?>" class="postComment" value="Post Comment">
                  <input type="hidden" name="comment_post_ID" value="<?php echo  get_the_ID(); ?>" id="comment_post_ID">

                  <input type="hidden" name="comment_parent" id="comment_parent_<?php echo  get_the_ID(); ?>" value="">

                </p>
              </form>
            </div> 
          </div>-->