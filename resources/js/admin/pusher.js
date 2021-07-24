$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    Pusher.logToConsole = true;

    var pusher = new Pusher("112f7a87d951cfe22faa", {
        cluster: "ap1"
    });

    var channel = pusher.subscribe("SendMailOrderUser");
    var id = $('meta[name="id_user"]').attr("content");
    channel.bind("send-message-order-" + id, function (data) {
        $('#order_id_toast').text(data.order.id);
        $('#status_toast').text(data.order.status);
        $('#message_order_toast').text(data.message_to_admin);
        $('#toast_order_user').attr('data-id', data.order.id);
        $("#toast_order_user").toast("show");
        $('#nav_count_noti').text(parseInt($('#nav_count_noti').text()) + 1);
    });

    $('#toast_order_user').on('click', function () {
        window.location = '/admin/orders/' + $(this).data('id');
    });
});
