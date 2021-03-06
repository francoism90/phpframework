$('#ajaxForm').submit(function(event) {
  event.preventDefault();
  dataString = $('#ajaxForm').serialize();
  $.ajax({
    type: "post",
    cache: false,
    url: $(this).attr('action'),
    dataType: "json",
    data: dataString,
		success: function (resp) {
      if (typeof resp === "object") {
        $('.row .msg').empty();
        $.each(resp, function(k, v) {
          $("label[for='"+ k +"']").parent().append('<p class="msg">' + v + '</p>');
        });
      }
      else { $('#ajaxForm').html(resp); }
    }
	})
	return false;
});
