'use strict';
const feedBackHoveMaterial = function(){
    const input = document.querySelectorAll('.popup__row:nth-child(odd) input');
    const inputLast = document.querySelectorAll('.popup__item.text-label input');

    inputLast.forEach(function (item) {
        const focusHandler = () => {
            let inputText = item.closest('label').querySelector('span');
            if (item.value) {
                inputText.style.cssText = "font-size: 12px; top: calc(100% + 5px); left: 0;";
            }
        };

        item.addEventListener('blur', focusHandler);
    })

    input.forEach(function (item) {
        const focusHandler = () => {
            let inputText = item.closest('label').querySelector('span');
            if (item.value) {
                inputText.style.cssText = "top: -15px; left: 0; font-size: 12px;";
            }
        };

        item.addEventListener('blur', focusHandler);
    })
};

feedBackHoveMaterial();