$(document).ready(
    $(document).on('click', '.link-filter', function() {
        let year = $(this).data('year');
        let month = $(this).data('month');
        $.pjax.reload({
            container: '#orders-list',
            url: '/order/index?year=' + year + '&month=' + month
        });
    })
);