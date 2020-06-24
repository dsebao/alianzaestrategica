"use strict"; // Start of use strict

var nonce = $('meta[name="csrf-token"]').attr('content');
$.ajaxSetup({headers: {'X-CSRF-TOKEN': nonce}});

function progressHandlingFunction(e){
    if(e.lengthComputable){
        var current = (e.loaded * 100) / e.total;
         $('.progress').css({'height': '3px'});
        $('.progress-bar').css({'width': current + '%'});
        if(current == 100){
        	$('.progress').css({'height': '0'});
            $('.progress-bar').css({'width': '0%'});
        }
    }
}

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
			//console.log(data);
            beforeSend(data);
        },
        success: function(data){
            //console.log(data);
            handleData(data);
        },
        error: function(e){
            console.log(e);
        }
    });
}

function ajaxSendMedia(formData,handleData,wait){
	$.ajax({
        type: "POST",
        url: jsvar.ajaxurl,
		data: formData,
        enctype: 'multipart/form-data',
        cache: false,
        timeout: 600000,
        contentType: false,
    	processData: false,
    	xhr: function() {
            var myXhr = $.ajaxSettings.xhr();
            if(myXhr.upload){ // Check if upload property exists
                myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
            }
            return myXhr;
        },
        beforeSend: function (data) {
        	wait(data);
        	$('html, body').css("cursor", "wait");
        },
        success: function(data){
        	handleData(data);
        	$('html, body').css("cursor", "auto");
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

function messageDiv(type,message){
	notie.alert({ type: type, text: message, time: 2 });
	//form.find('.message').html('<div class="mt-3 alert alert-' + type + '">' + message + '</div>');
}

function jsCustomAction(){

	// Detect custom actions
	$('*[data-action]').click(function(e){
		e.preventDefault();
		var t = $(this);
		var action = t.data('action');

		/*
		*
		* Define the user business type
		*
		*/
		if(action == 'js-select-business'){
			var dataval = t.data('val');
			
			//Send the option trough ajax to the db
			ajaxSend('action=sendform',function(data){
			},function(out){
			});
		}
	})
}

function ajaxForms(){

	//send the nonce through the ajax action

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
				console.log(out);
				if(out.result == 'success'){
					if(out.url != '')
						   window.location.href = out.url;
					if(out.resetform)
						form.trigger('reset');
				}
				if(typeof out.message !== 'undefined')
					messageDiv(out.type,out.message);
				
			});
			
		}
		form[0].classList.add('was-validated');
	});

	$('form.js-ajaxform-media').submit(function(event) {
		var form = $(this);
		var formdata = new FormData(form[0]);
		event.preventDefault();

		if (form[0].checkValidity() === false) {
			event.preventDefault();
			event.stopPropagation();
		} else {
			ajaxSendMedia(formdata,function(data){
				console.log(data);
				if(data.result){
					if(data.redirect != '')
						window.location.href = data.redirect;

				}
				
				if(typeof out.message !== 'undefined')
					messageDiv(out.type,out.message);
			},function(data){
			});

		}
		form[0].classList.add('was-validated');
	});
}


(function ($) {
	//Create ajax animation
	loadingAjax();

	$('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });

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

	jsCustomAction();

})(jQuery); // End of use strict