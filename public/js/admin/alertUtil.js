
if (!alertUtil) {
	alertUtil = function() {

		this.alertWarning = function (titulo, mensagem = "") {
			$('.content-header').after('<div class="alerta alerta-warning"><div class="wrap-icone"><i class="icone fa fa-exclamation"></i></div><div class="text"><span class="titulo">'+titulo+'</span><span>'+mensagem+'</span></div><a href="#" class="fecha-alerta"><i class="fa fa-times"></i></a></div>');

			$('.alerta').hide();
			$('.alerta').removeClass('active');
			setTimeout(function(){
				$('.alerta').show();
				$('.alerta').addClass('active');
			}, 200);

			setTimeout(function(){
				$(this).parents('.alerta').removeClass('active');
				$('.alerta').hide();
				$('.alerta').remove();
			}, 6000);

			$('.fecha-alerta').click(function(e){
				e.preventDefault();
				$(this).parents('.alerta').removeClass('active');
				$('.alerta').hide();
				$('.alerta').remove();
			});
		}

		this.alertError = function (titulo, mensagem = "") {

			$('.content-header').after('<div class="alerta alerta-danger"><div class="wrap-icone"><i class="icone fa fa-times"></i></div><div class="text"><span class="titulo">'+titulo+'</span><span>'+mensagem+'</span></div><a href="#" class="fecha-alerta"><i class="fa fa-times"></i></a></div>');

			$('.alerta').hide();
			$('.alerta').removeClass('active');
			setTimeout(function(){
				$('.alerta').show();
				$('.alerta').addClass('active');
			}, 200);

			setTimeout(function(){
				$(this).parents('.alerta').removeClass('active');
				$('.alerta').hide();
				$('.alerta').remove();
			}, 6000);

			$('.fecha-alerta').click(function(e){
				e.preventDefault();
				$(this).parents('.alerta').removeClass('active');
				$('.alerta').hide();
				$('.alerta').remove();
			});
		}

		this.alertInfo = function (titulo, mensagem = "") {

			$('.content-header').after('<div class="alerta alerta-info"><div class="wrap-icone"><i class="icone fa fa-info"></i></div><div class="text"><span class="titulo">'+titulo+'</span><span>'+mensagem+'</span></div><a href="#" class="fecha-alerta"><i class="fa fa-times"></i></a></div>');

			$('.alerta').hide();
			$('.alerta').removeClass('active');
			setTimeout(function(){
				$('.alerta').show();
				$('.alerta').addClass('active');
			}, 200);

			setTimeout(function(){
				$(this).parents('.alerta').removeClass('active');
				$('.alerta').hide();
				$('.alerta').remove();
			}, 6000);

			$('.fecha-alerta').click(function(e){
				e.preventDefault();
				$(this).parents('.alerta').removeClass('active');
				$('.alerta').hide();
				$('.alerta').remove();
			});
		}

		this.alertSuccess = function (titulo, mensagem = "") {

			$('.content-header').after('<div class="alerta alerta-success"><div class="wrap-icone"><i class="icone fa fa-check"></i></div><div class="text"><span class="titulo">'+titulo+'</span><span>'+mensagem+'</span></div><a href="#" class="fecha-alerta"><i class="fa fa-times"></i></a></div>');

			$('.alerta').hide();
			$('.alerta').removeClass('active');
			setTimeout(function(){
				$('.alerta').show();
				$('.alerta').addClass('active');
			}, 200);

			setTimeout(function(){
				$(this).parents('.alerta').removeClass('active');
				$('.alerta').hide();
				$('.alerta').remove();
			}, 6000);

			$('.fecha-alerta').click(function(e){
				e.preventDefault();
				$(this).parents('.alerta').removeClass('active');
				$('.alerta').hide();
				$('.alerta').remove();
			});

		}

	}

}



var alertUtil = new alertUtil();
