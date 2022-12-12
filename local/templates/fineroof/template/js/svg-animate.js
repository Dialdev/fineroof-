'use strict';

(function(){

	var objectsList = [
		{
			SVG: document.querySelector(".catalog__svg_worker"),
			defaultDur: 1000,
			property: -700,
		},
		{
			SVG: document.querySelector(".catalog__svg_hammer"),
			defaultDur: 660,
			property: 700,
		},
	];
    function animate(draw, duration) {
        var start = performance.now();

        requestAnimationFrame(function animate(time) {
            // определить, сколько прошло времени с начала анимации
            var timePassed = time - start;

            // возможно небольшое превышение времени, в этом случае зафиксировать конец
            if (timePassed > duration) timePassed = duration;

            // нарисовать состояние анимации в момент timePassed
            draw(timePassed);

            // если время анимации не закончилось - запланировать ещё кадр
            if (timePassed < duration) {
                requestAnimationFrame(animate);
            }

        });
    }
    var hoverDraw = function(item, sum, currentPos) {
        var start = Date.now();
        if (currentPos >= 0 && currentPos <= 45) {
            animate(function (timePassed) {
                sum === true ? item.setAttribute('y', currentPos + timePassed / 10.5) : item.setAttribute('y', currentPos - timePassed / 10.5);
            }, 500);
        }
    }
	function handleMapElement () {
		var mapButton = document.querySelector('.header__button');
		var mapLane = document.getElementById("mainPin");
        var mapPath = mapLane.querySelector('.hover-animation_background');
		if (mapLane !== null) {
			var handler = function  (event) {
				if (event.type == 'mouseover') {
                    hoverDraw(mapPath, true, 0);
					window.script.removePseudo();
				}
				if (event.type == 'mouseout') {
                    hoverDraw(mapPath, false, 45);
					window.script.removePseudo();
				}
			};
			mapButton.onmouseover = mapButton.onmouseout = handler;
		}

	}
	var createNSupportDraw = function(currentSvg, dur) {
		if (currentSvg !== null) {
				var animateSvg = function () {

					window.addEventListener('scroll', function () {
						let wHeight = this.innerHeight;
						document.querySelectorAll('.catalog__svg').forEach(function (item) {


							function getCoords() {
								return {
									itemTop: item.getBoundingClientRect().top + pageYOffset,
								};
							}

							let windowScroll = window.pageYOffset;

								if ((windowScroll + wHeight / 2 > getCoords().itemTop) && window.utils.visibility(item) === false && !item.classList.contains('animating')) {
									item.classList.add('animating');
									anime({
										targets: item,
										translateX: 0,
										easing: 'easeInOutBack',
										delay: 50,
										duration: dur,

									});
								} else {
									return
								}

						})
					});

				}
				animateSvg();

		}
	}

	var animatedGalery = function() {
		var svgWrapper = document.querySelector('.gallery__wrap');
		if (svgWrapper != null) {
			var SVG = document.querySelector('.galery-house');
		}
		if (SVG != null) {
			var animationUp = SVG.querySelector('.lights-up');
			var recolorElems = SVG.querySelectorAll('.recolor-elems');
			var handler = function (event) {

				if (event.type == 'mouseover') {

					anime({
						targets: animationUp,
						translateY: -10
					});
					recolorElems.forEach(function (elem) {
						anime({
							targets: elem,
							fill: '#1bc09b',
							easing: 'easeInOutSine',
							duration: 500
						});
					})
				}
				if (event.type == 'mouseout') {
					anime({
						targets: animationUp,
						translateY: 0
					});
					recolorElems.forEach(function (elem) {
						anime({
							targets: elem,
							fill: '#DAE9E5',
							easing: 'easeInOutSine',
							duration: 500
						});
					})
				}
			};
			svgWrapper.onmouseover = svgWrapper.onmouseout = handler;

		}
	}
	var animatedLogo = function() {
		var svgWrapper = document.querySelector('.header__image');
		if (svgWrapper != null) {
			var SVG = svgWrapper.querySelector('svg');
		}
		if (SVG != null) {
				var handler = function (event) {

					if (event.type == 'mouseover') {
						anime({
							targets: animationUp,
							translateX: 20,
							easing: 'easeInOutBack',
							duration: 600

						});
					}
					if (event.type == 'mouseout') {
						anime({
							targets: animationUp,
							translateX: 0,
							easing: 'easeInOutBack',
							duration: 600
						});
					}
				};
				svgWrapper.onmouseover = svgWrapper.onmouseout = handler;
				var animationUp = SVG.querySelector('.hover-animation_logo');
		}
	}
	var animatedYt = function() {
		var svgWrapper = document.querySelector('.jsChannel');
		if (svgWrapper != null) {
			var SVG = svgWrapper.querySelector('svg');
		}
		if (SVG != null) {
				var handler = function (event) {

					if (event.type == 'mouseover') {
						anime({
							targets: animationUp,
							translateX: 11,
							translateY: 7,

							scale: 0.7,
							easing: 'easeInOutBack',
							duration: 600

						});
					}
					if (event.type == 'mouseout') {
						anime({
							targets: animationUp,
							translateX: 0,
							translateY: 0,
							scale: 1,
							easing: 'easeInOutBack',
							duration: 600
						});
					}
				};
				svgWrapper.onmouseover = svgWrapper.onmouseout = handler;
				var animationUp = SVG.querySelector('.hover-animation_play');
		}
	}

	document.addEventListener('DOMContentLoaded', function () {
		handleMapElement();
		animatedGalery();
		animatedLogo();
		animatedYt();

		if (document.body.classList.contains('animated')) {
			for (let i = 0; i < objectsList.length; i++) {
				createNSupportDraw(objectsList[i].SVG, objectsList[i].defaultDur)
			}

		} else {
			return
		}

	})

})();
