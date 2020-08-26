$(function() {
    $('.toys-cart').on(
        'click',
        function(event) {
            let productId = $(this).data('productid');
            event.preventDefault();
            $.post(`/product/${productId}/add_to_cart`)
        }
    );

    $('#show_cart').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        $.post(`/product/show_cart`)
            .done(function(html) {
                $('#exampleModal').remove();
                $('body').append(html);
                $('#exampleModal').modal('show');
            });
    });

    $('.close1').on(
        'click',
        function(event) {
            let productId = $(this).closest('tr').data('productid');
            let that = $(this);
            event.preventDefault();
            $.post(`/product/${productId}/remove_from_cart`)
                .done(function(total) {
                    console.log(that);
                    $('#total').text(parseFloat(total));
                    that.closest('tr').remove();
                });
        }
    );
    $('.quantity-select .value-minus, .quantity-select .value-plus').on('click', function() {
        let productId = $(this).closest('tr').data('productid');
        let that = $(this);
        let itemCount = $(this).closest('.quantity-select').find('.item-count').text();
        event.preventDefault();
        $.post(`/product/${productId}/update_count`, {count: itemCount})
            .done(function(data) {
                let dataObj = JSON.parse(data);
                console.log(that);
                $('#total').text(parseFloat(dataObj.total));
                that
                    .closest('tr')
                    .find('.item-total')
                    .text(parseFloat(dataObj["item-price"]));
            });
    });
});