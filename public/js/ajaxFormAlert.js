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
        $("#alert").removeClass().empty().addClass('alert-error');
        $.each(resp, function(k, v) {
          $("#alert").append('<p class="label">' + k + '</p>');
          $.each(v, function(a, b) { $("#alert").append('<p>' + b + '</p>'); });
        });
        $("#alert").fadeIn();
      }
      else {
        $("#ajaxForm").html(resp);
      }
    }
	})
	return false;
});
