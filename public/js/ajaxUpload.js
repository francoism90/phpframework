$(function() {
  $("#fileuploader").uploadFile({
    url: '/upload/' + $('#ajaxForm #id').val(),
    fileName: 'upfile',
    maxFileSize: 500000,
    showPreview: true,
    allowedTypes: 'jpg,png,gif',
    acceptFiles: 'image/*',
    returnType: 'json'
  });
});
