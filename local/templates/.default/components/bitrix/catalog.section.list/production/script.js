/*$(function () {
    var elems = document.querySelectorAll('.catalog-list__block');
    var elemsLength = document.querySelectorAll('.catalog-list__block').length;
    var element = document.querySelectorAll('.catalog-list__detail.catalog-section');

    elems.forEach(function (checked, index) {
        checked.addEventListener('click', function (evt) {
            elems.forEach(function (item) {
                item.classList.remove('isActive')
            })
            for (var i = 0; i < element.length; i++) {
                element[i].classList.remove('isActive')
            }

            if (checked === this) {
                this.classList.add('isActive');
                element[index].classList.add('isActive');
            }
        })
    })
})*/