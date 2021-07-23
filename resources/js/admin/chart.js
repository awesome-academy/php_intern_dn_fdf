import $ from "jquery";

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const chart_month_order = new Chartisan({
        el: '#chart_month_order',
        url: "/api/chart/tracking_user_order",
    });
    const chart_week_order = new Chartisan({
        el: '#chart_week_order',
        url: "/api/chart/tracking_user_order_in_week",
    });

    $('#select_order').on('change', function () {
        var select = $(this).val();

        if (select == 'week') {
            $('#chart_month_order').addClass('d-none');
            $('#title_order_month').addClass('d-none');
            $('#title_order_week').removeClass('d-none');
            $('#chart_week_order').removeClass('d-none');
        } else {
            $('#chart_week_order').addClass('d-none');
            $('#title_order_week').addClass('d-none');
            $('#title_order_month').removeClass('d-none');
            $('#chart_month_order').removeClass('d-none');
        }
    });
});
