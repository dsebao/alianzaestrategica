"use strict"; // Start of use strict

function detectDirection() {
	if ($('.js-places-autocomplete').length > 0) {

		var options = {
			componentRestrictions: { country: "AR" }
		};
		new AddressAutocomplete('#form-direccion', options, function (result) {
			$('input.lat').val(result['coordinates']['lat']);
			$('input.lng').val(result['coordinates']['lng']);

			($('input[name="ciudad"]').length > 0) ? $('input[name="ciudad"]').val(result['cityName']) : "";
			($('input[name="street"]').length > 0) ? $('input[name="street"]').val(result['streetName']) : "";
			($('input[name="streetNumber"]').length > 0) ? $('input[name="streetNumber"]').val(result['streetNumber']) : "";
			($('input[name="provincia"]').length > 0) ? $('input[name="provincia"]').val(result['state']) : "";
		});
	}
}

function WordCount(str) {
	return str.split(" ").length;
}

function shortText() {
	var maxLength = 110;
	if ($('.js-long-text').length > 0) {
		$(".js-long-text").each(function () {
			var myStr = $(this).text();
			if ($.trim(myStr).length > maxLength) {
				var newStr = myStr.substring(0, maxLength);
				var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
				$(this).empty().html(newStr);
				$(this).append(' <a href="javascript:void(0);" class="js-read-more">leer más...</a>');
				$(this).append('<span class="js-more-text">' + removedStr + '</span>');
			}
		});
		$(".js-read-more").click(function () {
			$(this).siblings(".js-more-text").contents().unwrap();
			$(this).remove();
		});
	}
}

function tagsInput() {
	$('.tagsinput').tagsinput({
		maxTags: 2
	});
}

var nonce = $('meta[name="csrf-token"]').attr('content');
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': nonce } });

function progressHandlingFunction(e) {
	if (e.lengthComputable) {
		var current = (e.loaded * 100) / e.total;
		$('.progress').css({ 'height': '3px' });
		$('.progress-bar').css({ 'width': current + '%' });
		if (current == 100) {
			$('.progress').css({ 'height': '0' });
			$('.progress-bar').css({ 'width': '0%' });
		}
	}
}

function ajaxSend(mydata, beforeSend, handleData, datatype, type, globaltype) {
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
		success: function (data) {
			//console.log(data);
			handleData(data);
		},
		error: function (e) {
			console.log(e);
		}
	});
}

function ajaxSendMedia(formData, handleData, wait) {
	$.ajax({
		type: "POST",
		url: jsvar.ajaxurl,
		data: formData,
		enctype: 'multipart/form-data',
		cache: false,
		timeout: 600000,
		contentType: false,
		processData: false,
		xhr: function () {
			var myXhr = $.ajaxSettings.xhr();
			if (myXhr.upload) { // Check if upload property exists
				myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // For handling the progress of the upload
			}
			return myXhr;
		},
		beforeSend: function (data) {
			wait(data);
			$('html, body').css("cursor", "wait");
		},
		success: function (data) {
			handleData(data);
			$('html, body').css("cursor", "auto");
		}
	});
}


//Create loading spinner
function loadingAjax() {
	var loading = $('.globalcover');
	$(document).ajaxStart(function () {
		$('html, body').css("cursor", "wait");
		loading.fadeIn('fast');
	}).ajaxStop(function () {
		loading.hide();
		$('html, body').css("cursor", "auto");
	});
}

function messageDiv(type, message) {
	notie.alert({ type: type, text: message, time: 100 });
}

function mainSearchInput() {
	if ($('body.page-template-search').length > 0) {
		var urlParams = new URLSearchParams(window.location.search);
		var tiposearch = urlParams.get('tipo');

		if (tiposearch == 'servicios' || tiposearch == 'empresas' || tiposearch == 'productos') {
			$('form#mainsearch .search-panel span#search_concept').text(tiposearch);
		}



	}

	$('.search-panel .dropdown-menu').find('a').click(function (e) {
		e.preventDefault();
		var param = $(this).attr("href").replace("#", "");
		var concept = $(this).text();
		$('.search-panel span#search_concept').text(concept);
		$('.input-group #main-input-search').val(param);
		$('form#mainsearch').submit();
	});

}

function jsCustomAction() {

	// Detect custom actions
	$(document).on('click', '*[data-action]', function (e) {
		e.preventDefault();
		var t = $(this);
		var action = t.data('action');

		if (action == 'js-adherirme-empresa') {
			var empresa = t.data('idempresa');

			//Send the option trough ajax to the db
			ajaxSend('action=userform&typeform=adherirme_empresa_form&empresa=' + empresa, function (data) {
			}, function (out) {
				if (out.result == 'agregado')
					window.location.href = out.url;

			});
		}

		if (action == 'js-agregar-item') {
			var c = $('.js-container-item');
			//Send the option trough ajax to the db
			ajaxSend('action=userform&typeform=agregar_item_empresa', function (data) {
			}, function (out) {
				console.log(out);
				c.append(out);
			}, 'text');
		}

		if (action == 'js-delete-employee') {
			if (confirm('Deseas eliminar este usuario?')) {
				var meta = $(this).data('meta');

				//Send the option trough ajax to the db
				ajaxSend('action=userform&typeform=delete_employee&iduser=' + meta[0].usuario + '&empresa=' + meta[0].id, function (data) {
				}, function (out) {
					messageDiv(out.type, out.message);
					$(this).parent('tr#' + meta[0].usuario).remove();
				}, 'json');
			}

		}

		if (action == 'js-delete-item') {
			if (confirm('Deseas eliminar este item?')) {
				var iditem = $(this).data('id');
				var ide = $(this).data('empresa');

				//Send the option trough ajax to the db
				ajaxSend('action=userform&typeform=delete_item&iditem=' + iditem + '&e=' + ide, function (data) {
				}, function (out) {
					if (out.result == 'actualizado')
						window.location.href = out.redirect;

					messageDiv(out.type, out.message);
				}, 'json');
			}
		}

		if (action == 'js-clone') {
			var wrap = t.data('whereclone');
			var what = t.data('idclone');
			var content = $(what).html();
			$(wrap).append(content).promise().done(function () {
				console.log('Exito');
			});
		}

		if (action == 'js-remove-clone') {
			what = t.data('elementremove');
			t.closest(what).remove();
		}

		if (action == 'js-delete-presupuesto') {
			if (confirm('Deseas Eliminarlo?')) {
				alert('Eliminando...');
			}
		}
	})
}

function formvalidations() {
	$('form.simpleform').submit(function (event) {
		var form = $(this);

		if (form[0].checkValidity() === false) {
			event.preventDefault();
			event.stopPropagation();
			form[0].classList.add('was-validated');
		} else {
			return;
		}
	})
}

function ajaxForms() {

	//send the nonce through the ajax action

	$('form.js-ajaxform').submit(function (event) {
		var form = $(this);
		event.preventDefault();

		if (form[0].checkValidity() === false) {
			event.preventDefault();
			event.stopPropagation();
			form[0].classList.add('was-validated');
		} else {
			//Once the form passed the validation execute the ajax action
			ajaxSend(form.serialize(), function (data) {
			}, function (out) {
				console.log(out);
				if (out.result == 'success') {
					if (out.url != '')
						window.location.href = out.url;
					if (out.resetform)
						form.trigger('reset');
				}
				if (typeof out.message !== 'undefined')
					messageDiv(out.type, out.message);

			});
		}
	});


	$('form.js-ajaxform-media').submit(function (event) {
		var form = $(this);
		var formdata = new FormData(form[0]);
		event.preventDefault();

		if (form[0].checkValidity() === false) {
			event.preventDefault();
			event.stopPropagation();
		} else {
			ajaxSendMedia(formdata, function (data) {
				console.log(data);
				if (data.result) {
					if (data.redirect != '')
						window.location.href = data.redirect;
				}

				if (typeof out.message !== 'undefined')
					messageDiv(out.type, out.message);
			}, function (data) {
			});
		}
		form[0].classList.add('was-validated');
	});

	$('form.js-consultacuit').submit(function (event) {
		var form = $(this);
		event.preventDefault();

		if (form[0].checkValidity() === false) {
			event.preventDefault();
			event.stopPropagation();
			form[0].classList.add('was-validated');
		} else {
			//Once the form passed the validation execute the ajax action
			ajaxSend(form.serialize(), function (data) {
			}, function (out) {
				form.find('.js-return').html(out);
			}, 'text');
		}
	});

	$('form.js-form-edit-employee').submit(function (event) {
		var form = $(this);
		event.preventDefault();

		if (form[0].checkValidity() === false) {
			event.preventDefault();
			event.stopPropagation();
			form[0].classList.add('was-validated');
		} else {
			//Once the form passed the validation execute the ajax action
			ajaxSend(form.serialize(), function (data) {
			}, function (out) {
				console.log(out);
				if (out.result != 'error') {
					window.location.href = out.redirect;
				}
			}, 'json');
		}
	});
}

function dinamicModal() {
	$('#employee-edit').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var meta = button.data('meta');

		var modal = $(this);

		modal.find('.modal-content input#nombre').val(meta[0].nombre);
		modal.find('.modal-content input#empresa').val(meta[0].id);
		modal.find('.modal-content input#iduser').val(meta[0].usuario);
		modal.find('.modal-content select#rol').val(meta[0].rol);
		modal.find('.modal-content select#estado').val(meta[0].estado);
	});
}

function messageCenter() {
	if ($('.js-message').length > 0) {
		var tt = $('.js-message').data('type');
		var tm = $('.js-message').data('message');
		messageDiv(tt, tm);
	}
}

(function ($) {
	//Create ajax animation
	loadingAjax();

	shortText();

	$('input[type="file"]').change(function (e) {
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

	$('.customselect').select2({
		theme: 'bootstrap4',
	});

	formvalidations();

	ajaxForms();

	jsCustomAction();

	detectDirection();

	dinamicModal();

	messageCenter();

	tagsInput();

	var tabledata = $('.dataTable').DataTable();

	mainSearchInput();

})(jQuery); // End of use strict