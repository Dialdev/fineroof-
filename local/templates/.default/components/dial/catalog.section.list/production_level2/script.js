$(function () {

    var brandList = document.querySelectorAll('.brand-select__position');

    brandList.forEach(function (item, i) {
        item.addEventListener('click', function (evt) {

            for (var j = 0; j < brandList.length; j++) {
                brandList[j].classList.remove('isActive');
            }
            if(item === evt.target) {
                item.classList.add('isActive');

                var first = document.querySelector('.brand-select__position:first-child');
                var parent = first.parentNode;
                parent.insertBefore(item, first);
            }
        })
    })


    $('body').on('click', '.brand-select__position', function (e) {
        $('.ajax_refresh').fadeOut();
        $('.catalog-section__desc').fadeOut();
        $('#brandlist').submit();
    })

    $('body').on('submit', '#brandlist', function (e) {
        e.preventDefault();
        $this = $(this).find('[name="brand"]').val();
        $.get($(this).data('action'), {'brand': $this, 'AJAX_PAGE': 'Y', 'clear_cache': 'Y' }, function (data) {
            $('.ajax_refresh').children().remove();
            $('.ajax_refresh').append(data);
            $('.ajax_refresh').fadeIn();
        });
        $.get($(this).data('action'), {'brandID': $this, 'AJAX_BRAND': 'Y', 'clear_cache': 'Y' }, function (data) {
            $('.catalog-section__desc').children().remove();
            $('.catalog-section__desc').append(data);
            $('.catalog-section__desc').fadeIn();
        });
    })

})

