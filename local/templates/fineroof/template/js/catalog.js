"use strict";
(function () {
      var openBrandList = function (index, multiListRow) {
          var brandTabs = document.querySelectorAll(multiListRow);
          brandTabs.forEach(function (brand, i) {
              brand.classList.remove('isActive');
              if (i === index && brand.parentNode.classList.contains('isActive')) {
                  brand.classList.add('isActive');
              }
              ;
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
          var checkTabItem = document.querySelector('.jsTab')
          if (checkTabItem) {
              document.querySelector('.jsTab').classList.add('isActive');
              document.querySelector('.props-table__list').classList.add('isActive');
          }


          createLightBox('jsBoxSertificate');
          //createLightBox('jsFacedes');
          if (document.querySelector('.items-slider__wrap') !== null) {
              var swiper = new Swiper ('.items-slider__wrap', {
                  slidesPerView: 10,
                  spaceBetween: 64,
                  watchOverflow: true,
                  navigation: {
                      nextEl: '.slider-right_color',
                      prevEl: '.slider-left_color',
                  },
                  breakpoints: {
                      1075: {
                          slidesPerColumn: 2,
                          slidesPerGroup:1,
                          slidesPerView:5,
                          spaceBetween: 20,
                      },
                      479: {
                          slidesPerColumn: 3,
                          slidesPerGroup:1,
                          slidesPerView:3,
                          spaceBetween: 10,
                      }
                  },
              })
          }
          if (document.querySelector('.images-slider__wrapper') !== null) {
              var swiper = new Swiper ('.images-slider__wrapper', {
                  slidesPerView: 5,
                  spaceBetween: 64,
                  watchOverflow: true,
                  navigation: {
                      nextEl: '.slider-right_images-slider',
                      prevEl: '.slider-left_images-slider',
                  },
                  breakpoints: {
                      1075: {
                          slidesPerView:4,
                          spaceBetween: 64,
                      },
                      610: {
                          slidesPerView:3,
                          spaceBetween: 64,
                      },
                      479: {
                          slidesPerView:2,
                          spaceBetween: 64,
                      },
                      360:{
                          slidesPerView:2,
                          spaceBetween: 35,
                      }
                  },
              })
          }

      })
})();
