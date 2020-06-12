
function ajaxSend(mydata,beforeSend,handleData,type,datatype,globaltype){
	var type = type || 'POST';
	var datatype = datatype || 'json';
	var globaltype = globaltype || true;

    $.ajax({
        type: type,
        url: jsvar.ajaxurl,
        dataType: datatype,
        data: mydata,
        global: globaltype,
        beforeSend: function (data) {
            beforeSend(data);
        },
        success: function(data){
            console.log(data);
            handleData(data);
        },
        error: function(e){
            console.log(e);
            //$.notify(e,{type: 'danger'});
        }
    });
}


//Create loading spinner
function loadingAjax(){
	var loading = $('.globalcover');
	$(document).ajaxStart(function () {
		$('html, body').css("cursor", "wait");
	    loading.fadeIn('fast');
	}).ajaxStop(function () {
	    loading.hide();
	    $('html, body').css("cursor", "auto");
	});
}


(function ($) {
	"use strict"; // Start of use strict

	function ajaxForms(){
		
		//send the nonce through the ajax action

		var nonce = $('meta[name="csrf-token"]').attr('content');
		$.ajaxSetup({headers: {'X-CSRF-TOKEN': nonce}});
	
		$('form.js-ajaxform').submit(function(event) {
			var form = $(this);
			event.preventDefault();

			if (form[0].checkValidity() === false) {
				event.preventDefault();
				event.stopPropagation();
			} else {
				//Once the form passed the validation execute the ajax action
				ajaxSend(form.serialize(),function(data){
					
				},function(out){
					
				});
					
			}
			form[0].classList.add('was-validated');

		});
	}

	//Create ajax animation
	loadingAjax();

	// Toggle the side navigation
	$("#sidebarToggle, #sidebarToggleTop").on('click', function (e) {
		$("body").toggleClass("sidebar-toggled");
		$(".sidebar").toggleClass("toggled");
		if ($(".sidebar").hasClass("toggled")) {
			$('.sidebar .collapse').collapse('hide');
		};
	});

	// Close any open menu accordions when window is resized below 768px
	$(window).resize(function () {
		if ($(window).width() < 768) {
			$('.sidebar .collapse').collapse('hide');
		};

		// Toggle the side navigation when window is resized below 480px
		if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
			$("body").addClass("sidebar-toggled");
			$(".sidebar").addClass("toggled");
			$('.sidebar .collapse').collapse('hide');
		};
	});

	// Prevent the content wrapper from scrolling when the fixed side navigation hovered over
	$('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function (e) {
		if ($(window).width() > 768) {
			var e0 = e.originalEvent,
				delta = e0.wheelDelta || -e0.detail;
			this.scrollTop += (delta < 0 ? 1 : -1) * 30;
			e.preventDefault();
		}
	});

	// Scroll to top button appear
	$(document).on('scroll', function () {
		var scrollDistance = $(this).scrollTop();
		if (scrollDistance > 100) {
			$('.scroll-to-top').fadeIn();
		} else {
			$('.scroll-to-top').fadeOut();
		}
	});

	// Smooth scrolling using jQuery easing
	$(document).on('click', 'a.scroll-to-top', function (e) {
		var $anchor = $(this);
		$('html, body').stop().animate({
			scrollTop: ($($anchor.attr('href')).offset().top)
		}, 1000, 'easeInOutExpo');
		e.preventDefault();
	});

	ajaxForms();

})(jQuery); // End of use strict