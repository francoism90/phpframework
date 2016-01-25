$(function() {
  $('.lazy').lazy();
});

$('.list').each(function() {
    var currentPage = 0;
    var numPerPage = 16;
    var $entry = $(this);
    $entry.bind('repaginate', function() {
        $entry.find('.e').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
    });
    $entry.trigger('repaginate');
    var numRows = $entry.find('.e').length;
    var numPages = Math.ceil(numRows / numPerPage);
    var $pager = $('<div class="pager"></div>');
    for (var page = 0; page < numPages; page++) {
        $('<span class="page-number"></span>').text(page + 1).bind('click', {
            newPage: page
        }, function(event) {
            currentPage = event.data['newPage'];
            $entry.trigger('repaginate');
            $(this).addClass('active').siblings().removeClass('active');
        }).appendTo($pager).addClass('clickable');
    }
    $pager.insertBefore($entry).find('span.page-number:first').addClass('active');
});
