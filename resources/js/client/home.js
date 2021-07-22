$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#logout-form').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            method: 'POST',
            url: '/logout',
            success: function (data) {
                location.reload();
            }
        })
    });

    $('.btn-logout').on('click', function () {
        $('#logout-form').submit();
    });

    // login
    $('#loginForm').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serializeArray();
        $(".invalid-feedback").children("strong").text("");
        $("#loginForm input").removeClass("is-invalid");
        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: '/login',
            data: formData,
            success: () => window.location.reload(),
            error: (response) => {
                $("#loginForm #passwordInput").val('');
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    Object.keys(errors).forEach(function (key) {
                        $("#" + key + "Input").addClass("is-invalid");
                        $("#" + key + "Error").children("strong").text(errors[key][0]);
                    });
                } else {
                    window.location.reload();
                }
            }
        })
    });

    //register
    $('#registerForm').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serializeArray();
        $(".invalid-feedback").children("strong").text("");
        $("#registerForm input").removeClass("is-invalid");
        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: '/register',
            data: formData,
            success: () => window.location.reload(),
            error: (response) => {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    Object.keys(errors).forEach(function (key) {
                        $("#" + key + "Input").addClass("is-invalid");
                        $("#" + key + "Error").children("strong").text(errors[key][0]);
                    });
                } else {
                    window.location.reload();
                }
            }
        })
    });

    //forgot password
    $('#forgotPassForm').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serializeArray();
        $(".invalid-feedback").children("strong").text("");
        $("#forgotPassForm input").removeClass("is-invalid");
        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: '/password/email',
            data: formData,
            success: function (data) {
                $('#message').children("strong").text(data.message)
            },
            error: (response) => {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    Object.keys(errors).forEach(function (key) {
                        $("#" + key + "InputForgot").addClass("is-invalid");
                        $("#" + key + "ErrorForgot").children("strong").text(errors[key][0]);
                    });
                } else {
                    window.location.reload();
                }
            }
        })
    });

    // In menu
    $('.btn-show-product').on('click', function () {
        var id = $(this).data('cate-id');

        var locale = $('meta[name="locale"]').attr('content');

        var message;

        locale == 'en' ? message = 'Avarage rate of product' : message = 'Đánh giá trung bình';

        $.ajax({
            method: 'GET',
            url: '/menu/get-product-by-cate-id/' + id,
            success: function (data) {
                var html = '';
                Object.keys(data).forEach(key => {
                    html += '<div class="col-md-4 special-grid drinks">' +
                            '<div class="gallery-single fix">' +
                                '<img src="/storage/'+ data[key].image +'" alt="Image" width="254" height="152">' +
                                '<div class="why-text">' +
                                    '<h4>'+ data[key].name +'</h4>' +
                                    '<p>'+ message + ': ' + data[key].avg_rating + '* (' + data[key].ratings.length + ')' + '</p>' +
                                    '<div class="d-flex justify-content-around">' +
                                    '<h5>'+ data[key].price +' vnd</h5>' +
                                    '<a href="/products/'+ data[key].id +'"><i class="fas fa-eye cursor"></i></a>' +
                                    '<a class="add-to-cart" data-product-id="'+ data[key].id +'"><i class="fas fa-shopping-cart cursor"></i></a>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
                });
                $('#list_products').html(html);
            }
        });
    });

    // rating
    $('#form_add_rating').on('submit', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        let formData = $(this).serializeArray();
        $(".invalid-feedback").children("strong").text("");
        $("#form_add_rating input").removeClass("is-invalid");
        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: '/products/'+ id +'/rating',
            data: formData,
            success: function (data) {
                $("#form_add_rating textarea").val('');
                var html = renderRating(data);
                var avg_rate = parseFloat($('#avg_rate').text());
                var count_rate = parseFloat($('#count_rate').text());

                var last_avg = ((avg_rate * count_rate) + data.pivot.num_rated) / (count_rate + 1);

                $('#avg_rate').text(last_avg.toFixed(1));
                $('#count_rate').text(count_rate + 1);
                $('#list_ratings').prepend(html);
            },
            error: (response) => {
                $("#form_add_rating textarea").val('');
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    console.log(errors);
                    Object.keys(errors).forEach(function (key) {
                        $("#" + key + "InputRating").addClass("is-invalid");
                        $("#" + key + "ErrorRating").children("strong").text(errors[key][0]);
                    });
                } else if (response.status === 401) {
                    $('#modalLogin').modal('show');
                }
            }
        })
    });

    function renderRating(data)
    {
        var star = '';
        for (var i = 1; i <= 5; i++) {
            if (i <= data.pivot.num_rated) {
                star += '<button type="button" class="btn btn-warning btn-xs mr-1" aria-label="Left Align">' +
                    '<i class="fas fa-star"></i>' +
                '</button>';
            } else {
                star += '<button type="button" class="btn btn-warning btn-grey btn-xs mr-1" aria-label="Left Align">' +
                    '<i class="fas fa-star"></i>' +
                '</button>';
            }
        }

        var formattedDate = new Date(data.pivot.created_at);
        var d = formattedDate.getDate();
        var m =  formattedDate.getMonth();
        m += 1;
        var y = formattedDate.getFullYear();
        var result = d + "-" + m + "-" + y;

        var html = '<div class="review-block">' +
                '<div class="row">' +
                '<div class="col-sm-3">' +
                '<img src="http://dummyimage.com/60x60/666/ffffff&text=No+Image" class="img-rounded">' +
                '<div class="review-block-name">'+ data.name +'</div>' +
                '<div class="review-block-date">'+ result +'<br />Just now</div>' +
                '</div>' +
                '<div class="col-sm-9">' +
                '<div class="review-block-rate">' +
                star +
                '</div>' +
                '<div class="review-block-title">'+ data.pivot.content +'</div>' +
                '</div>' +
                '</div>' +
                '<hr />' +
                '</div>';
        return html;
    }

    $('.progress-bar').on('click', function () {
        var id = $(this).data('product-id');
        var num_rate = $(this).data('num-rate');

        $.ajax({
            method: 'GET',
            url: '/products/'+ id +'/rating/' + num_rate,
            success: function (data) {
                var html = '';
                Object.keys(data).forEach(key => {
                    html += renderRating(data[key]);
                })
                $('#list_ratings').html(html);
            }
        });
    });

    // add cart
    $('body').on('click', '.add-to-cart', function () {
        var id = $(this).data('product-id');

        addCartAjax(id, 1);
    });

    // add more quantity
    $('#add_to_cart').on('click', function () {
        var id = $(this).data('product-id');
        var quantity = parseInt($('#quantity').val());

        addCartAjax(id, quantity);
    });

    function addCartAjax(id, quantity)
    {
        $.ajax({
            method: 'POST',
            url: '/cart/'+ id + '/add',
            data: {quantity: quantity},
            success: function (data) {
                $('#nav_count').text(parseInt(data.totalQuantity));
                $('#total_price').text(data.totalPrice);

                if ($('#product-' + data.product.id).length <= 0) {
                    $('#list_items').append('<tr id="product-'+ data.product.id +'">' +
                    '<td class="w-25">' +
                    '<img src="/storage/'+ data.product.image +'" class="img-fluid img-thumbnail" alt="Sheep">' +
                    '</td>' +
                    '<td>'+ data.product.name +'</td>' +
                    '<td>'+ data.product.price +'</td>' +
                    '<td class="pr-0">' +
                    '<a class="cursor btn-minus-product" data-product-id="'+ data.product.id +'"><i class="fas fa-minus"></i></a>' +
                    '</td>' +
                    '<td class="qty"><input type="text" class="form-control  pl-1 pr-1" id="qty-'+ data.product.id +'" value="'+ data.product.quantity +'"></td>' +
                    '<td class="pr-l">' +
                    '<a class="cursor btn-plus-product" data-product-id="'+ data.product.id +'"><i class="fas fa-plus"></i></a>' +
                    '</td>' +
                    '<td id="total-'+ data.product.id +'">'+ data.product.price * data.product.quantity +'</td>' +
                    '<td>' +
                    '<a class="btn btn-danger cursor btn-remove-product" data-product-id="'+ data.product.id +'">' +
                    '<i class="fa fa-times"></i>' +
                    '</a>' +
                    '</td>' +
                    '</tr>');
                } else {
                    $('#qty-'+ data.product.id).val(data.product.quantity);
                    $('#total-'+ data.product.id).text(parseInt($('#total-'+ data.product.id).text()) + ( data.product.price * quantity ));
                }
            },
        });
    }

    // plus product cart
    $('#list_items').on('click', '.btn-plus-product', function () {
        var id = $(this).data('product-id');

        var quantityCurrent = parseInt($('#qty-'+ id).val());

        $.ajax({
            method: 'PUT',
            url: '/cart/'+ id + '/update',
            data: {quantity : (quantityCurrent + 1)},
            success: function (data) {
                $('#nav_count').text(parseInt(data.totalQuantity));
                $('#total_price').text(data.totalPrice);

                $('#qty-'+ data.product.id).val(data.product.quantity);
                $('#total-'+ data.product.id).text(parseInt($('#total-'+ data.product.id).text()) + data.product.price);
            },
        });
    });

    // minus product cart
    $('#list_items').on('click', '.btn-minus-product', function () {
        var id = $(this).data('product-id');

        var quantityCurrent = parseInt($('#qty-'+ id).val());

        if (quantityCurrent <= 1) {
            removeAjax(id);

            return false;
        }

        $.ajax({
            method: 'PUT',
            url: '/cart/'+ id + '/update',
            data: {quantity : (quantityCurrent - 1)},
            success: function (data) {
                $('#nav_count').text(parseInt(data.totalQuantity));
                $('#total_price').text(data.totalPrice);

                $('#qty-'+ data.product.id).val(data.product.quantity);
                $('#total-'+ data.product.id).text(parseInt($('#total-'+ data.product.id).text()) - data.product.price);
            },
        });
    });

    // remove product form cart
    $('#list_items').on('click', '.btn-remove-product', function () {
        var id = $(this).data('product-id');

        removeAjax(id);
    });

    function removeAjax(id)
    {
        $.ajax({
            method: 'DELETE',
            url: '/cart/'+ id + '/delete',
            success: function (data) {
                $('#nav_count').text(parseInt(data.totalQuantity));
                $('#total_price').text(data.totalPrice);
                $('#product-' + id).remove();
            },
        });
    }

    // plus input add cart
    $('.btn-plus').on('click', function () {
        $('#quantity').val(parseInt($('#quantity').val()) + 1);

        checkQuantityInput();
    });

    // minus input add cart
    $('.btn-minus').on('click', function () {
        $('#quantity').val(parseInt($('#quantity').val()) - 1);

        checkQuantityInput();
    });

    function checkQuantityInput()
    {
        var quantity = parseInt($('#quantity').val());

        if (quantity <= 1) {
            $('#btn_minus').prop('disabled', true);
        } else {
            $('#btn_minus').prop('disabled', false);
        }
    }

    checkQuantityInput();

    // preview avatar user
    var readURL = function (input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }


    $(".file-upload").on('change', function () {
        readURL(this);
    });

    // change pass profile
    $('#changePasswordForm').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serializeArray();
        $(".invalid-feedback").children("strong").text("");
        $("#changePasswordForm input").removeClass("is-invalid");
        $.ajax({
            method: "PUT",
            headers: {
                Accept: "application/json"
            },
            url: '/profile/password/change',
            data: formData,
            success: function (response) {
                $("#changePasswordForm input").val('');
                $(".alert-password").children("strong").text(response.message);
                $(".alert-password").removeClass('d-none');
            },
            error: (response) => {
                $("#changePasswordForm input").val('');
                if (response.status === 422) {
                    if (typeof response.responseJSON.errors !== 'undefined') {
                        let errors = response.responseJSON.errors;
                        Object.keys(errors).forEach(function (key) {
                            console.log(key)
                            $("#" + key + "Input").addClass("is-invalid");
                            $("#" + key + "Error").children("strong").text(errors[key][0]);
                        });
                    } else {
                        $("#oldpasswordInput").addClass("is-invalid");
                        $("#oldpasswordError").children("strong").text(response.error);
                    }
                }
            }
        })
    });

    // checkout form
    $('#form_check_out').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serializeArray();
        $(".invalid-feedback").children("strong").text("");
        $("#form_check_out input").removeClass("is-invalid");
        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: '/checkout',
            data: formData,
            success: function (response) {
                $("#form_check_out input").val('');
                $(".alert-checkout").children("strong").text(response.message);
                $(".alert-checkout").removeClass('d-none');
            },
            error: (response) => {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    Object.keys(errors).forEach(function (key) {
                        $("#" + key + "InputCheckout").addClass("is-invalid");
                        $("#" + key + "ErrorCheckout").children("strong").text(errors[key][0]);
                    });
                } else if (response.status === 401) {
                    $('#modalLogin').modal('show');
                }
            }
        })
    });

    // suggest
    $('#cateInputSuggest').on('change', function () {
        var id = $("#cateInputSuggest option:selected").val();

        $.ajax({
            method : 'GET',
            url : '/category/' + id + '/child',
            success: function (data) {
                $('#cate-hidden').removeClass('d-none');
                $('#cate_child').text('');
                Object.keys(data.cate_child).forEach(key => {
                    $('#cate_child').append('<option value="'+ data.cate_child[key].id +'">'+ data.cate_child[key].name +'</option>');
                });
            }
        });
    });

    $('#form_suggest').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serializeArray();
        $(".invalid-feedback").children("strong").text("");
        $("#form_suggest input").removeClass("is-invalid");
        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: '/suggest',
            data: formData,
            success: function (response) {
                console.log(response)
                $("#form_suggest input").val('');
                $(".alert-suggest").children("strong").text(response.message);
                $(".alert-suggest").removeClass('d-none');
            },
            error: (response) => {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    Object.keys(errors).forEach(function (key) {
                        $("#" + key + "InputSuggest").addClass("is-invalid");
                        $("#" + key + "ErrorSuggest").children("strong").text(errors[key][0]);
                    });
                } else if (response.status === 401) {
                    $('#modalLogin').modal('show');
                }
            }
        })
    });

    // search
    $('#search').on('keyup', function (e) {
        if (e.which <= 90 && e.which >= 48 || e.which == 8) {
            var word = $(this).val();

            if (word === '') {
                return false;
            }

            $.ajax({
                method: 'GET',
                url: '/search/' + word,
                success: function (data) {
                    var html = '';
                    if (Object.keys(data).length > 0) {
                        Object.keys(data).forEach(key => {
                            html += '<a href="/products/'+ data[key].id +'" class="item-link">'+ data[key].name +'</a><hr>';
                        })
                    } else {
                        html += '<a class="item-link cursor">Not found</a>';
                    }
                    $('#list_search').html(html);
                    $('#list_search').removeClass('d-none');
                }
            });
        }
    });

    $(document).click(function (e) {
        var container = $(".search-chit");

        if (!container.is(e.target)) {
            $('#list_search').addClass('d-none');
        }
    });

    // favorite
    $('.add-my-favorite').on('click', function () {
        var id = $(this).data('product-id');

        $.ajax({
            method: 'POST',
            url: '/favorite/' + id,
            success: function (data) {
                if (typeof data.message_success !== 'undefined') {
                    $('#count_favorite').text(parseInt($('#count_favorite').text()) + 1);
                }
            },
        });
    });

    // favorite
    $('#modalFavorite').on('click', function () {
        $.ajax({
            method: 'GET',
            url: '/favorite',
            success: function (data) {
                var html = '';
                if (Object.keys(data).length > 0) {
                    Object.keys(data).forEach(key => {
                        html += '<tr id="favorite-'+ data[key].id +'">' +
                                '<td class="w-25"><img src="/storage/'+ data[key].image +'" class="img-fluid img-thumbnail" alt="Sheep"></td>' +
                                '<td>'+ data[key].name +'</td>' +
                                '<td>'+ data[key].price +' vnd</td>' +
                                '<td>' +
                                '<a class="add-to-cart" data-product-id="'+ data[key].id +'"><i class="fas fa-shopping-cart fa-2x cursor"></i></a>' +
                                '</td>' +
                                '<td>' +
                                '<a class="btn btn-danger cursor btn-remove-favorite" data-product-id="'+ data[key].id +'">' +
                                '<i class="fa fa-times"></i>' +
                                '</a>' +
                                '</td>' +
                                '</tr>';
                    });
                }
                $('#list_favorite').html(html);
            }
        })
    });

    $('body').on('click', '.btn-remove-favorite', function () {
        var id = $(this).data('product-id');

        $.ajax({
            method: 'DELETE',
            url: '/favorite/' + id,
            success: function () {
                $('#favorite-' + id).remove();
                $('#count_favorite').text(parseInt($('#count_favorite').text()) -1);
            }
        })
    });

    $('.order-bar').on('click', function () {
        var type = $(this).data('type');

        $.ajax({
            method: 'GET',
            url: '/order/' + type + '/type',
            success: function (data) {
                var html = '';
                if (Object.keys(data).length > 0) {
                    Object.keys(data).forEach(key => {
                        var btn_cancel = '';
                        var formattedDate = new Date(data[key].created_at);
                        var d = formattedDate.getDate();
                        var m =  formattedDate.getMonth();
                        m += 1;
                        var y = formattedDate.getFullYear();
                        var result = d + "-" + m + "-" + y;
                        if (data[key].status == 'Pending') {
                            btn_cancel = '<td><a class="btn btn-danger cursor btn-cancel-order" data-order-id="'+ data[key].id +'">Cancel order</a></td>';
                        }

                        html += '<tr id="order-'+ data[key].id +'">' +
                                '<td>#'+ data[key].id +'</td>' +
                                ' <td>'+ result +'</td>' +
                                '<td>'+ data[key].totalPrice +'</td>' +
                                '<td>'+ data[key].status +'</td>' +
                                btn_cancel +
                                '</tr>';
                    });
                }
                $('#list_order').html(html);
            }
        });
    });

    $('body').on('click', '.btn-cancel-order', function () {
        var id = $(this).data('order-id');

        $.ajax({
            method: 'PUT',
            url: '/order/' + id,
            success: function (data) {
                var btn_cancel = '';
                var formattedDate = new Date(data.created_at);
                var d = formattedDate.getDate();
                var m =  formattedDate.getMonth();
                m += 1;
                var y = formattedDate.getFullYear();
                var result = d + "-" + m + "-" + y;
                if (data.status == 'Pending') {
                    btn_cancel = '<td><a class="btn btn-danger cursor btn-cancel-order" data-order-id="'+ data.id +'">Cancel order</a></td>';
                }
                var html = '<td>#'+ data.id +'</td>' +
                            ' <td>'+ result +'</td>' +
                            '<td>'+ data.totalPrice +'</td>' +
                            '<td>'+ data.status +'</td>' +
                            btn_cancel;
                $('#order-' + id).html(html);
                $('#nav_count_noti').text(parseInt($('#nav_count_noti').text()) + 1);
            }
        })
    });

    var slider = tns({
        arrowKeys: true,
        container: ".js-sliderImageViewer",
        controls: false,
        loop: false,
        mouseDrag: true,
        navContainer: ".js-imageViewerNav",
    });

    $('#modalNotifyOpen').on('click', function () {
        $.ajax({
            method: 'GET',
            url: '/notifications/order',
            success: function (data) {
                var html = '';
                if (Object.keys(data).length > 0) {
                    Object.keys(data).forEach(key => {
                        html += '<div class="row curs">' +
                                '<div class="col-sm-10">' +
                                '<div class="d-flex">' +
                                '<a href="/order/'+ data[key].data['order']['id'] +'">#'+ data[key].data['order']['id'] +' '+ data[key].data['order']['status'] +'</a>' +
                                '</div>' +
                                '<p>'+ data[key].data['message'] +'</p>' +
                                '</div>' +
                                '<div class="col-sm-2">' +
                                '<i class="far fa-bell"></i>' +
                                '</div>' +
                                '</div>'
                    });
                }
                $('#list_notify').html(html);
                $('#nav_count_noti').text(0);
            }
        })
    });
});
