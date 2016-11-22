@extends('layouts.app')

@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo (isset($imagem)) ? 'Editar' : 'Criar'; ?>
			<small>Informações da Imagem</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ url('/admin/<ROTA_MODULO>') }}"><LABEL_MODULO></a></li>
			<li><a href="{{ url('/admin/<ROTA_MODULO>/edit/'.$<ITEM_MODULO>->id) }}">Editar <LABEL_MODULO></a></li>
			<li class="active"><?php echo (isset($imagem)) ? 'Editar' : 'Criar'; ?> Imagem</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<div class="box-header">

					</div>   
					<!-- /.box-header -->
					<div class="box-body">
						<ul class="nav nav-pills nav-justified">
							<li class="active"><a data-toggle="pill" href="#info-tab">Imagem</a></li>
						</ul>
						<div class="spacer"></div>
						
						<div class="tab-content">
							
								<div id="info-tab" class="tab-pane fade in active">
									<form id="mainForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/<ROTA_MODULO>/save-imagem') }}">
										{{ csrf_field() }}
										<input type="hidden" name="thumbnail_principal" value="<?php echo (isset($imagem)) ? $imagem->thumbnail_principal : ''; ?>">
										<?php if(isset($imagem)){ ?>
											<input type="hidden" name="id" value="<?php echo $imagem->id; ?>"/>
										<?php } ?>
										<input type="hidden" name="id_<ITEM_MODULO>" value="<?php echo $<ITEM_MODULO>->id; ?>"/>
									</form>
									<div class="form-horizontal">
										<div class="form-group">
											<label for="image" class="col-md-3 control-label">Imagem</label>
											<div class="col-md-7">
												<form action="{{ url('admin/<ROTA_MODULO>/upload') }}" method="post" class="form single-dropzone" id="my-dropzone" enctype="multipart/form-data">
													<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
													<div id="img-thumb-preview">
														<img id="img-thumb" class="user size-lg img-thumbnail img-responsive" src="<?php echo (isset($imagem) && $imagem->thumbnail_principal != '') ? url('/uploads/<ROTA_MODULO>/'.$imagem->thumbnail_principal) : 'http://placehold.it/300x100'; ?>">
													</div>
													<button type="button" style="display:none;" id="crop-image" class="btn btn-success">Salvar Corte</button>
													<button id="upload-submit" class="btn btn-default margin-t-5"><i class="fa fa-upload"></i> Upload Picture</button>
												</form>
												<form class="hidden" action="{{ url('admin/<ROTA_MODULO>/crop') }}" id="cropForm" method="POST">
													<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
													<input type="hidden" name="data_crop">
													<input type="hidden" name="file_name">
												</form>
											</div>
										</div>
									</div>
								</div>
								
							
							
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<div class="text-center">
							<button type="submit" class="btn btn-primary">
								<i class="fa fa-btn fa-pencil"></i> Salvar
							</button>
						</div>
					</div>
				</div>
					<!-- /.box -->
			</div>
		</div>
	</section>
</div>
<script type="text/javascript">

</script>
@endsection
