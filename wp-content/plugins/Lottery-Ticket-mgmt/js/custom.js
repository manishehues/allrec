jQuery(document).ready(function () {
  $(document).on("submit", "#entry_form", function (e) {
    e.preventDefault();
    $(".wqmessage").html("");
    $(".wqsubmit_message").html("");

    var wqtitle = $("#wqtitle").val();
    var wqdescription = $("#wqdescription").val();

    if (wqtitle == "") {
      $("#wqtitle_message").html("Title is Required");
    }
    if (wqdescription == "") {
      $("#wqdescription_message").html("Description is Required");
    }

    if (wqtitle != "" && wqdescription != "") {
      var fd = new FormData(this);
      var action = "wqnew_entry";
      fd.append("action", action);

      $.ajax({
        data: fd,
        type: "POST",
        url: ajax_var.ajaxurl,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
          var res = JSON.parse(response);
          $(".wqsubmit_message").html(res.message);
          if (res.rescode != "404") {
            $("#entry_form")[0].reset();
            $(".wqsubmit_message").css("color", "green");
          } else {
            $(".wqsubmit_message").css("color", "red");
          }
        },
      });
    } else {
      return false;
    }
  });

  $(document).on("submit", "#update_form", function (e) {
    e.preventDefault();
    $(".wqmessage").html("");
    $(".wqsubmit_message").html("");

    var wqtitle = $("#wqtitle").val();
    var wqdescription = $("#wqdescription").val();

    if (wqtitle == "") {
      $("#wqtitle_message").html("Title is Required");
    }
    if (wqdescription == "") {
      $("#wqdescription_message").html("Description is Required");
    }

    if (wqtitle != "" && wqdescription != "") {
      var fd = new FormData(this);
      var action = "wqedit_entry";
      fd.append("action", action);

      $.ajax({
        data: fd,
        type: "POST",
        url: ajax_var.ajaxurl,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
          var res = JSON.parse(response);
          $(".wqsubmit_message").html(res.message);
          if (res.rescode != "404") {
            $(".wqsubmit_message").css("color", "green");
          } else {
            $(".wqsubmit_message").css("color", "red");
          }
        },
      });
    } else {
      return false;
    }
  });

  $(document).on("submit", "#gen_winner", function (e) {
    e.preventDefault();

    var post_id = $("#gen_post_id").val();
    var action = "gen_winner";

    var data = { post_id: post_id, action: action };

    $.ajax({
      data: data,
      type: "POST",
      url: ajax_var.ajaxurl,
      success: function (response) {
        console.log(response);
        var res = JSON.parse(response);
        $(".wqsubmit_message").html(res.message);
        if (res.rescode != "404") {
          $(".wqsubmit_message").css("color", "green");
        } else {
          $(".wqsubmit_message").css("color", "#ffffcc");
        }
      },
    });
  });
});
