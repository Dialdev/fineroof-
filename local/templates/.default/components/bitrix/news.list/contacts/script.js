function maps(coord, paramsID) {

    ymaps.ready(function () {

        var myMap,
            place = {},
            myCollection = new ymaps.GeoObjectCollection();

        var coordX = parseFloat(coord['X'][0]);
        var coordY = parseFloat(coord['Y'][0]);

        myMap = new ymaps.Map('ymap', {
            center: [coordX, coordY], // Начальные значения центра карты
            zoom: 13, // Начальное значение зума карты

        });

        for (var i = 0; i < paramsID.length; i++) {
            var coordX = parseFloat(coord['X'][i]);
            var coordY = parseFloat(coord['Y'][i]);
            place[i] = new ymaps.Placemark(
                [coordX, coordY], {balloonContent: ''}, {
                    iconLayout: 'default#image',
                    iconImageHref: '/upload/mapholder.png',
                    iconImageSize: [50, 49],
                    iconImageOffset: [-50, -49]
                });
            myCollection.add(place[i]);
        }
        myMap.geoObjects.add(myCollection);

        myMap.behaviors.disable('scrollZoom'); //убрать зум по скроллу
        myMap.controls.remove('typeSelector'); // убрать выбор карт
        myMap.controls.remove('trafficControl'); // убрать пробки
        myMap.controls.remove('searchControl'); // убрать поиск
        myMap.controls.remove('fullscreenControl'); // убрать фуллскрин
        myMap.controls.remove('rulerControl'); // убрать линейку

        var isMobile = {
            Android: function () {
                return navigator.userAgent.match(/Android/i);
            },
            BlackBerry: function () {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            iOS: function () {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Opera: function () {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            Windows: function () {
                return navigator.userAgent.match(/IEMobile/i);
            },
            any: function () {
                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
            }
        };
        if (isMobile.any()) {
            myMap.behaviors.disable('drag');
        }

        var mapID = document.querySelectorAll('.contacts__column');

        mapID.forEach(function (item, i) {
            item.addEventListener('click', function (evt) {
                if (item === this) {
                    var coord = place[i].geometry.getCoordinates();
                    myMap.panTo(coord);
                }
            });
        })
    });
}