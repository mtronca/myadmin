$(document).ready(function(){

  /* DataTable PARA AS LISTAGENS */
  $('#list-data-table, .list-data-table').DataTable({
      "paging": true,
      "searching": true,
      "ordering": true,
      "info": true,
   });

	/*
	Script para submeter o formulário caso não possua campos required em branco.
	Faz a validação dos campos required do #mainForm
	*/
  $('.box-footer [type="submit"]').click(function(e){
	e.preventDefault();
	var wrongValidation = 0;
	var inputsNumber = 0;
   $('#mainForm [required]').each(function(){
		//console.log(tinyMCE.editors[$(this).attr('id')].getContent());
     if(!$(this).val() || ($(this).is('textarea') && !tinyMCE.editors[$(this).attr('id')].getContent())){
		 inputsNumber++;
       $(this).css('border-color', '#dd4b39');
		 if($(this).is('textarea')){
			if(!tinyMCE.editors[$(this).attr('id')].getContent()){
				$(this).prev().css('border-color', '#dd4b39');
			}else{
				wrongValidation++;
			}
		 }
     }
   });
	if(inputsNumber > wrongValidation){
		$('[href="#info-tab"]').closest('ul').find('li.active').removeClass('active');
      $('[href="#info-tab"]').closest('li').attr('class', 'active');
      $('.tab-content .tab-pane').removeClass('in active');
      $('#info-tab').addClass('in active');
		alertUtil.alertError('Verifique os erros do formulário.');
	}else{
		$('#mainForm').submit();
	}
  });

  $('#mainForm input').focus(function(){
    $(this).css('border-color', '#3c8dbc');
  });

  $('#mainForm input').blur(function(){
    $(this).css('border-color', '#d2d6de');
  });


  /*
  $('.session-return-wrapper .fa-times').click(function(){
  	$('.session-return-wrapper').fadeOut();
  });*/

  $('[href="#"]').click(function(e){
    e.preventDefault();
  });

  $('.fecha-alerta').click(function(){
    $(this).parents('.alerta').removeClass('active');
    $('.alerta').hide();
    $('.alerta').remove();
  });

  /* MASCARAS */
  //Datemask dd/mm/yyyy
  $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
  //Datemask2 mm/dd/yyyy
  $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
  //Money Euro
  $("[data-mask]").inputmask();

  /* BUSCA DE ENDERECO POR CEP */
  $('[name="cep"]').blur(function() {
      var cep = $(this).val().replace('-', '').replace('.', '');
      var verify = $.trim(cep);
      $.ajax({
          url: "/admin/contato/getcep",
          dataType: 'json',
          type: 'POST',
          data: {
              'cep': verify,
              '_token': $('[name="_token"]').val()
          },
          success: function(resultadoCEP) {
              if (resultadoCEP["resultado"] == "1" || resultadoCEP["resultado"] == "2") {
                  $('[name="endereco"]').val(unescape(resultadoCEP["tipo_logradouro"]) + " " + unescape(resultadoCEP["logradouro"]) + ", "+ unescape(resultadoCEP["bairro"]) + ", "+ unescape(resultadoCEP["cidade"]));
                  //$(div_endereco).find('[name="endereco-fieldset[cidade]"]').val(unescape(resultadoCEP["cidade"]));
                  $('[name="enderecoGmaps"]').val(unescape(resultadoCEP["tipo_logradouro"]) + " " + unescape(resultadoCEP["logradouro"]));
                  $('[name="enderecoGmaps"]').focus();

              }
          },
          error: function(xhr, ajaxOptions, thrownError) {
              bf2Util.alertError(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
      });

  });

  /* UPLOAD E CROP DE IMAGEM */
  //Dropzone.js Options - Upload an image via AJAX.
  if(document.getElementById('my-dropzone')){
      Dropzone.options.myDropzone = {
        uploadMultiple: false,
        // previewTemplate: '',
        addRemoveLinks: false,
        // maxFiles: 1,
        dictDefaultMessage: '',
        init: function() {
          this.on("addedfile", function(file) {
            // console.log('addedfile...');
          });
          this.on("thumbnail", function(file, dataUrl) {
            // console.log('thumbnail...');
            $('.dz-image-preview').hide();
            $('.dz-file-preview').hide();
          });
          this.on("success", function(file, res) {
				  //$('.dz-preview').remove();
              console.log('upload success...');
              $('#img-thumb').attr('src', res.path);
              $('input[name="pic_url"]').val(res.path);
              var image = document.getElementById('img-thumb');
              var cropper = new Cropper(image, {
                crop: function(e) {
                  /*console.log(e.detail.x);
                  console.log(e.detail.y);
                  console.log(e.detail.width);
                  console.log(e.detail.height);*/
                }
              });
              $('#upload-submit').hide();

              $('#crop-image').fadeIn();

              $('#crop-image').click(function(){
                $('#cropForm [name="data_crop"]').val(JSON.stringify(cropper.getData()));
                $('#cropForm [name="file_name"]').val(res.file_name);
                $.ajax({
                  url:$('#cropForm').attr('action'),
                  type:$('#cropForm').attr('method'),
                  dataType:'JSON',
                  data:$('#cropForm').serialize(),
                  beforeSend:function(){

                  },
                  success:function(data){
                    if(data.status){
                      $('#img-thumb').attr('src',data.path);
                      $('[name="thumbnail_principal"]').val(data.file_name);
                      cropper.destroy();
                      $('#crop-image').hide();
                      $('#upload-submit').fadeIn();
                    }else{
                      alert(data.message);
                    }
                  }
                });
              });
          });
        }
      };
      var myDropzone = new Dropzone("#my-dropzone");

      $('#upload-submit').on('click', function(e) {
        e.preventDefault();
        //trigger file upload select
        $("#my-dropzone").trigger('click');
      });
  }

  if(document.getElementById('my-dropzone2')){
      Dropzone.options.myDropzone2 = {
        uploadMultiple: false,
        addRemoveLinks: false,
        dictDefaultMessage: '',
        init: function() {
          this.on("addedfile", function(file) {
            // console.log('addedfile...');
          });
          this.on("thumbnail", function(file, dataUrl) {
            // console.log('thumbnail...');
            $('.dz-image-preview').hide();
            $('.dz-file-preview').hide();
          });
          this.on("success", function(file, res) {
              console.log('upload success...');
              $('#img-thumb2').attr('src', res.path);
              $('input[name="pic_url"]').val(res.path);
              var image = document.getElementById('img-thumb2');
              var cropper = new Cropper(image, {
                crop: function(e) {
                }
              });
              $('#upload-submit2').hide();
              $('#crop-image2').fadeIn();

              $('#crop-image2').click(function(){
                $('#cropForm2 [name="data_crop"]').val(JSON.stringify(cropper.getData()));
                $('#cropForm2 [name="file_name"]').val(res.file_name);
                $.ajax({
                  url:$('#cropForm2').attr('action'),
                  type:$('#cropForm2').attr('method'),
                  dataType:'JSON',
                  data:$('#cropForm2').serialize(),
                  beforeSend:function(){

                  },
                  success:function(data){
                    if(data.status){
                      $('#img-thumb2').attr('src',data.path);
                      $('[name="thumbnail_secundaria"]').val(data.file_name);
                      cropper.destroy();
                      $('#crop-image2').hide();
                      $('#upload-submit2').fadeIn();
                    }else{
                      alert(data.message);
                    }
                  }
                });
              });
          });
        }
      };
      var myDropzone2 = new Dropzone("#my-dropzone2");

      $('#upload-submit2').on('click', function(e) {
        e.preventDefault();
        //trigger file upload select
        $("#my-dropzone2").trigger('click');
      });
  }

  tinymce.init({
    selector:'.tinymce',
    force_br_newlines : true,
    force_p_newlines : false,
    forced_root_block : '', // Needed for 3.x
    plugins: [
      "advlist autolink lists link image charmap print preview anchor",
      "searchreplace visualblocks code fullscreen",
      "insertdatetime media table contextmenu paste jbimages"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
    relative_urls: false
  });

  $('.deletar').click(function(e){
    if(!confirm('Você tem certeza? Isso não pode ser desfeito.')){
      e.preventDefault();
    }
  });

  $('[name="titulo"], [name="nome"]').slugify({ slug: '[name="slug"]', type: '-' });

  $('.delete-image').click(function(){
	  var id = $(this).attr('data');
	  var modulo = $(this).attr('data-modulo');
	  $.ajax({
			 url: '/admin/'+modulo+'/delete_imagem/'+id,
			 dataType: 'JSON',
			 data:{
				 _token : $('[name="_token"]').val()
			 },
			 type: "POST",
			 success: function(data) {
				 $( '.imagem-galeria-' + id).remove();
				 if(data.status){
					 alertUtil.alertSuccess(data.message);
				 }else{
					 alertUtil.alertError(data.message);
				 }

			  }

		 });

  });

  $('.select2').select2();

  $('.select-icone').change(function(){
	  $('.icone-viewer i').attr('class','');
	  $('.icone-viewer i').attr('class', 'fa fa-3x '+$(this).val());
  });if($('.select-icone') !== undefined) $('.select-icone').trigger('change');

});
