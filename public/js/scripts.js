$( document ).ready(function() {

	$('#menub').click(function(){
		$('.mob').slideToggle();
	});

	$('.gallery').each(function() {
	    $(this).magnificPopup({
	        delegate: 'a',
	        type: 'image',
	        gallery: {
	          enabled:true
	        }
	    });
	});

	if(window.google_maps!==undefined) {
        maps_initialize();
    }

    function plx(){
		$('.parallax-box').parallax();
    }plx();

    $(window).resize(function(){
    	plx();
    });

    $('.datepicker').datepicker({
    	format: "dd/mm/yyyy",
	    autoclose: true,
	    language: "pt-BR"
    });

    $('#contatoForm, #solicitarForm').submit(function(e){
		e.preventDefault();
		$.ajax({
			url:$(this).attr('action'),
			type:$(this).attr('method'),
			dataType:'json',
			data:$(this).serialize(),
			beforeSend:function(){
				$('.carregando').fadeIn();
			},
			success:function(data){
				if(data.status){
					$('.adicionado i').attr('class', 'fa fa-check-circle');
				}else{
					$('.adicionado i').attr('class', 'fa fa-times');				
				}
				$('.adicionado span').html(data.message);
				$('.adicionado').fadeIn();
				$('.carregando').fadeOut();
			},
			error : function(xhr, textStatus, errorThrown) {
				if (xhr.status === 0) {
					alert('Falha na conexão.\n Verifique o sinal de Internet.');
				} else if (xhr.status == 404) {
					alert('Falha ao localizar a página. [404]');
				} else if (xhr.status == 500) {
					alert('Falha no servidor [500].');
				} else if (errorThrown === 'parsererror') {
					alert('Falha na requisição.');
				} else if (errorThrown === 'timeout') {
					alert('Tempo esgotado.');
				} else if (errorThrown === 'abort') {
					alert('Solicitação abortada.');
				} else {
					alert('Ocorreu um erro. Tente novamente!');
				}
			}
		});
	});

	$('#fecha-confirma').click(function(){
		$('.adicionado').fadeOut();
	});

	$('#dicas-tabs a').click(function(e){
		e.preventDefault();
		var target = $(this).attr('href');
		$('.dica-tab-div').addClass('hidden');
		$(target).removeClass('hidden');
		$('#dicas-tabs li').removeClass('active');
		$(this).closest('li').addClass('active');
	});

});
