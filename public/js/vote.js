$(function() {
    let flag = true;
    $('.starRating label').on('click', function() {
        if(!flag) {
            return;
        }
        let id = $(this).attr('for');
        console.log(id);
        let star = $(`#${id}`).val();
        console.log(`Stars clicked: ${star}`);
        $('.preloader').show();
        $.post(`/product/${PRODUCT_ID}/vote`, {vote: star, token: TOKEN})
            .done(function(val) {
                flag = false;
                $(`.starRating label[for="rating${val}"]`).click();
                flag = true;
            })
            .always(function () {
                $('.preloader').hide();
            });
    });
});