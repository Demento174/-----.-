$( document ).ready(function() {
//--------------------------------------[ Modal Close ]
	$('.modal .close').click(function () {
		$('.modal').modal('hide')
	});
//--------------------------------------[ fancybox ]
	$('.fancybox').fancybox();
//--------------------------------------[ scroll  ]
	$(".scroll").on("click", function (event) {

		event.preventDefault();

		var id  = $(this).attr('href');
		var	top = $(id).offset().top-100;

		$('body,html').animate({
			scrollTop: top
		}, 1500);

	});
//--------------------------------------[ scroll fo first block ]
	var firstSection = $('main.content section.categorie').eq(0).attr('id');
	$('section.title a.buttonAnimation').attr('href','#'+firstSection);
//--------------------------------------[ smoke ]
	$(function() {
		if (!$.browser.msie) {
			var a = 0;
			for (; a < 115; a += 1) {
				setTimeout(function b() {
					var a = Math.random() * 1e3 + 5e3,
						c = $("<div />", {
							"class": "smoke",
							css: {
								opacity: 0,
								left: Math.random() * 1200 + 80
							}
						});
					$(c).appendTo("#viewport");
					$.when($(c).animate({
						opacity: 1
					}, {
						duration: a / 4,
						easing: "linear",
						queue: false,
						complete: function() {
							$(c).animate({
								opacity: 0
							}, {
								duration: a / 3,
								easing: "linear",
								queue: false
							})
						}
					}), $(c).animate({
						bottom: $("#viewport").height()
					}, {
						duration: a,
						easing: "linear",
						queue: false
					})).then(function() {
						$(c).remove();
						b()
					})
				}, Math.random() * 3e3)
			}
		} else {
			"use strict";
			var a = 0;
			for (; a < 15; a += 1) {
				setTimeout(function b() {
					var a = Math.random() * 1e3 + 5e3,
						c = $("<div />", {
							"class": "smoke",
							css: {
								left: Math.random() * 200 + 80
							}
						});
					$(c).appendTo("#viewport");
					$.when($(c).animate({}, {
						duration: a / 4,
						easing: "linear",
						queue: false,
						complete: function() {
							$(c).animate({}, {
								duration: a / 3,
								easing: "linear",
								queue: false
							})
						}
					}), $(c).animate({
						bottom: $("#viewport").height()
					}, {
						duration: a,
						easing: "linear",
						queue: false
					})).then(function() {
						$(c).remove();
						b()
					})
				}, Math.random() * 3e3)
			}
		}
	}())
});


