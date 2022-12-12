"use strict";
(function () {

    var openBrandList = function (index, multiListRow) {
        var brandTabs = document.querySelectorAll(multiListRow);
        brandTabs.forEach(function (brand, i) {
            brand.classList.remove('isActive');
            brand.classList.remove('galery-block');
            brand.querySelector('.galery-block__slider').classList.remove('isActive');
            if (i === index && brand.parentNode.classList.contains('isActive')) {
                brand.classList.add('isActive');
                brand.classList.add('galery-block');
                brand.querySelector('.galery-block__slider').classList.add('isActive');

                slider = brand.querySelector('.galery-block__slider');

                var swiper = new Swiper('.galery-block__slider.isActive', {
                    slidesPerGroup: 3,
                    slidesPerColumn: 3,
                    slidesPerView: 3,
                    spaceBetween: 0,
                    navigation: {
                        nextEl: '.slider-right_galery',
                        prevEl: '.slider-left_galery',
                    },
                    breakpoints: {
                        900: {
                            slidesPerGroup: 2,
                            slidesPerView: 2,
                        },
                        610: {
                            slidesPerColumn: 6,
                            slidesPerGroup: 1,
                            slidesPerView: 1,
                        }
                    },
                });

                var group = slider.querySelector('.jsFacedesGallery');
                var groupClass = group.getAttribute('data-group');
                //createLightBox('jsFacedes');
                createLightBox(groupClass);
            };
        });
    };
    var multiTabsNavigation = function (multiTabsNode, multiListRow) {
        var tabsRow = document.querySelectorAll(multiTabsNode);
        tabsRow.forEach(function (child, index) {
            child.addEventListener('click', function (evt) {
                tabsRow.forEach(function (removeClassItem) {
                    removeClassItem.classList.remove('isActive');
                });
                var target = evt.target;
                if (child === target) {
                    child.classList.add('isActive');
                    openBrandList(index, multiListRow);
                }
            });
        });
    };
    var createLightBox = function (elementClass) {
        var checkElement = document.querySelector('.' + elementClass)
        if (checkElement !== null) {
            var lightboxDescription = GLightbox({
                selector: elementClass,
                height: 400,
                width: 800
            });
        }
    }
    document.addEventListener('DOMContentLoaded', function () {

        multiTabsNavigation('.jsTab', '.props-table__list');

        var group = document.querySelector('.jsFacedesGallery');
        var groupClass = group.getAttribute('[data-group]');
        createLightBox(groupClass);

        if (document.querySelector('.galery-block__slider') !== null) {
            var tabClick = document.querySelector('.props-table__tab.isActive').click();
        }

    })
})();
