import './bootstrap';

$(document).ready(function () {
    $('#per_page').on('change', function () {
        $(this).parents('form').submit();
    });

    $('.product-attr-radio').on('change', function () {
        $(this).parents('form').submit();
    });
});


