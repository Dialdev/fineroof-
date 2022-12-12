"use strict";
(function () {
    document.addEventListener('DOMContentLoaded', function () {
        var getList = function (collect, tag) {
            var ulList = document.querySelectorAll('.' + collect);

            ulList.forEach(function (item) {
                var ulListItem = item.querySelector(tag);

                if (ulListItem !== undefined && ulListItem !== null) {
                    ulListItem.classList.add('props-table__desc');
                }

            })
        }
        getList('props-table__item', 'ul');
        getList('props-table__item', 'ol');

        var jsAjaxColor = function(ajaxColor, ajaxImage) {
        	var colorsWrapper = document.querySelector('.items-slider__title');
			ajaxColor.forEach(function (item, i) {
				item.addEventListener('click', function () {
					var dataIDColor = item.getAttribute('data-id') || null;
					var dataIDImage = document.querySelector('.ajax__image[data-id="' + dataIDColor + '"]') || null;
					var dataIDColorName = item.getAttribute('data-name');
					if (dataIDImage !== null) {
						ajaxColor.forEach(function (itemColor, i) {
							itemColor.classList.remove('isActive');
						});
						ajaxImage.forEach(function (itemImage, i) {
							itemImage.classList.remove('isActive');
						});
						item.classList.add('isActive');
						dataIDImage.classList.add('isActive');
						colorsWrapper.innerHTML = dataIDColorName;
					}
				});
				item.addEventListener('mouseover', function () {
					var dataIDColorName = item.getAttribute('data-name');
					colorsWrapper.innerHTML = dataIDColorName;
				});
			})
			var container = document.querySelector('.items-slider__body');
			container.addEventListener('mouseout', function () {
				var elem = document.querySelector('.items-slider__item.isActive');
				var dataIDColorName = elem.getAttribute('data-name');
				colorsWrapper.innerHTML = dataIDColorName;
			});
        }

		var ajaxColor = document.querySelectorAll('.ajax__color');
		var ajaxImage = document.querySelectorAll('.ajax__image');

		jsAjaxColor(ajaxColor, ajaxImage);
    })

})();
