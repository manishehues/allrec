jQuery(function ($) {
  /*
   * On comment form submit
   */

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
      },
      complete: function () {
        // what to do after a comment has been added
        button.removeClass("loadingform").val("Post Comment");
      },
    });
    return false;
  });

  /*
   * On comment reply form submit
   */
  $(".comment-reply-link").click(function () {
    var parentCmntID = $(this).attr("rel");
    var cmntPost = $(this).data("post_id");
    //var textArea = $(this).("post_id");
    console.log(parentCmntID);
    console.log(cmntPost);

    $("#comment_parent_" + cmntPost).val(parentCmntID);

    $("#comment_" + cmntPost).focus();

    //console.log(cmntPost);
  });

  /*
   * On comment like
   */

  var count = 0;
  $(".like-comment").click(function () {
    count++;
    likeCount = $(this).html("like " + count);
    var parentCmntID = $(this).attr("rel");

    var data0 = { numberId: likeCount, cmntid: parentCmntID, action: cmntlike };

    $.ajax({
      type: "POST",
      url: misha_ajax_comment_params.ajaxurl,
      data: data0,

      success: function (response) {
        alert("woo hoo 1");
        if (response) {
          alert("woo hoo 2");
        }
      },
    });
    return false;
  });
});
