$(function() {
    $('.add_to_cart').on(
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
});