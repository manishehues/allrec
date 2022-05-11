jQuery(function ($) {
  /*
   * On comment form submit
   */

  $(".foruserScrool").scrollTop($(".foruserScrool")[0].scrollHeight);

  $(".postComment").click(function () {
    var from_id = $(this).attr("rel");

    // define some vars
    var button = $("#submit" + from_id), // submit button
      respond = $("#respond" + from_id + " ul.commentslist"), // comment form container
      commentlist = $("#comment" + from_id), // comment list container
      cancelreplylink = $("#cancel-comment-reply-link");

    $.ajax({
      type: "POST",
      url: misha_ajax_comment_params.ajaxurl, // admin-ajax.php URL
      data: $("#commentform_" + from_id).serialize() + "&action=ajaxcomments", // send form data + action parameter
      beforeSend: function (xhr) {
        // what to do just after the form has been submitted
        button.addClass("loadingform").val("Loading...");
      },
      error: function (request, status, error) {
        if (status == 500) {
          alert("Error while adding comment");
        } else if (status == "timeout") {
          alert("Error: Server doesn't respond.");
        } else {
          // process WordPress errors
          var wpErrorHtml = request.responseText.split("<p>"),
            wpErrorStr = wpErrorHtml[1].split("</p>");

          alert(wpErrorStr[0]);
        }
      },

      success: function (addedCommentHTML) {
        $("#respond" + from_id + " ul.commentslist").html("");

        // if this post already has comments
        $("#respond" + from_id + " ul.commentslist").append(addedCommentHTML);

        // clear textarea field
        $("#comment_" + from_id).val("");

        // remove reply div
        $(".replyComment1").html("");

        // scroll to bottom after reply
        $(".foruserScrool").scrollTop($(".foruserScrool")[0].scrollHeight);
      },
      complete: function () {
        // what to do after a comment has been added
        button.removeClass("loadingform").val("Post");
      },
    });
    return false;
  });

  /*
   * On comment reply form submit
   */

  $("html").on("click", ".comment-reply-link", function () {
    var parentCmntID = $(this).attr("rel");
    var cmntPost = $(this).data("post_id");

    $("#comment_parent_" + cmntPost).val(parentCmntID);

    var reply = $(this).data("reply");
    var cmntstr = $(this).data("str");

    var shortcmnt =
      jQuery.trim(cmntstr).substring(0, 10).split(" ").slice(0, -1).join(" ") +
      "...";

    $("#comment_" + cmntPost).before(
      "<div class='replyComment1'> " +
        reply +
        " <div class='reply'> <span> " +
        shortcmnt +
        "</span></div></div>"
    );

    $("#comment_" + cmntPost).focus();
  });

  /*
   * On comment like
   */

  $("html").on("click", ".like-comment", function () {
    var comment_id = $(this).attr("rel");
    var count = $(this).find(".likes").html();
    count++;
    likeCount = $(this).find(".likes").html(count);

    var data = {
      comment_id: comment_id,
      action: "cmntlike",
    };

    $.ajax({
      type: "POST",
      url: misha_ajax_comment_params.ajaxurl,
      data: data,

      success: function (response) {
        if (response) {
          // window.location.reload();
        }
      },
    });
  });

  /*
   * submit lottery number to db
   */

  $("html body").on("click", ".add_participants", function () {
    var currentPostId = $(this).data("post-id");
    $(".current_post_id").val(currentPostId);
  });

  $("html body").on("click", ".participant", function () {
    var post_id = $(".current_post_id").val();
    var user_id = $(".current_user_id").val();
    var ticket_number = $(".ticket_number").val();

    var data11 = {
      post_id: post_id,
      user_id: user_id,
      ticket_number: ticket_number,
      action: "numberadd",
    };

    $.ajax({
      type: "POST",
      url: misha_ajax_comment_params.ajaxurl,
      data: data11,

      success: function (response) { window.location.reload();
        // if (response) {
         
        // }
      },
    });
  });
});
