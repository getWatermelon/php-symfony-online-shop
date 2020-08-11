$(function() {
    $('#add_to_cart').on(
        'click',
        function(event) {
            event.preventDefault();
            $.post(`/product/${PRODUCT_ID}/add_to_cart`, {token : TOKEN})
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