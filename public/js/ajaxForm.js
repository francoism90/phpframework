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
      if (typeof resp === "string") $('#ajaxForm').html(resp);
      else {
        $('.row .msg').empty();
        $.each(resp, function(k, v) {
          $.each(v, function(a, b) { $("label[for='"+ k +"']").parent().append('<p class="msg">' + b + '</p>'); });
        });
      }
    }
	})
	return false;
});
