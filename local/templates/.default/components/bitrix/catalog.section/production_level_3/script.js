(function () {
    var ajaxPagerLoadingClass = 'ajax-pager-loading',
        ajaxPagerWrapClass = 'ajax-pager-wrap',
        ajaxPagerLinkClass = 'ajax-pager-link',
        ajaxWrapAttribute = 'wrapper-class',
        ajaxPagerLoadingTpl = ['<span class="' + ajaxPagerLoadingClass + '">', 'Загрузка…', '</span>'].join(''),
        busy = false,
        attachPagination = function (wrapperClass) {
            var $wrapper = $('.' + wrapperClass),
                $window = $(window);
        }, ajaxPagination = function (e) {
            e.preventDefault();
            busy = true;
            var wrapperClass = $('.' + ajaxPagerLinkClass).data(ajaxWrapAttribute),
                $wrapper = $('.' + wrapperClass),
                $link = $(this);
            if ($wrapper.length) {
                $('.' + ajaxPagerWrapClass).append(ajaxPagerLoadingTpl);
                $.get($link.attr('href'), {'AJAX_PAGE': 'Y'}, function (data) {
                    $('.' + ajaxPagerWrapClass).remove();
                    $wrapper.append(data);
                    attachPagination(wrapperClass);
                    busy = false;
                });
            }
        };
    $(function () {
        if ($('.' + ajaxPagerLinkClass).length && $('.' + ajaxPagerLinkClass).data(ajaxWrapAttribute).length) {
            attachPagination($('.' + ajaxPagerLinkClass).data(ajaxWrapAttribute));
            $(document).on('click', '.' + ajaxPagerLinkClass, ajaxPagination);
        }

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
            $('.ajax_pagination').fadeOut();
            $('.catalog-section__desc').fadeOut();
            $('#brandlist').submit();
        })

        $('body').on('submit', '#brandlist', function (e) {
            e.preventDefault();
            $this = $(this).find('[name="brand"]').val();

            $.get($(this).data('action'), {'brand': $this, 'AJAX_PAGE': 'Y', 'clear_cache': 'Y' }, function (data) {
                $('.ajax_pagination').children().remove();
                $('.ajax_pagination').append(data);
                $('.ajax_pagination').fadeIn();
            });
            $.get($(this).data('action'), {'brandID': $this, 'AJAX_BRAND': 'Y', 'clear_cache': 'Y' }, function (data) {
                $('.catalog-section__desc').children().remove();
                $('.catalog-section__desc').append(data);
                $('.catalog-section__desc').fadeIn();
            });
        })
    });
})();

