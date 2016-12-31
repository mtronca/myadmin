@extends('layouts.app')

@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo (isset($<ITEM_MODULO>)) ? 'Editar' : 'Criar'; ?>
			<small>Informações <LABEL_MODULO></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ url('/admin/<ROTA_MODULO>') }}"><LABEL_MODULO></a></li>
			<li class="active"><?php echo (isset($<ITEM_MODULO>)) ? 'Editar' : 'Criar'; ?></li>
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
							<li class="active"><a data-toggle="pill" href="#info-tab">Informações</a></li>
							<?php if($modulo->imagem){ ?>
								<li><a data-toggle="pill" href="#image-tab">Imagem</a></li>
							<?php } ?>
							<?php /*<li><a data-toggle="pill" href="#image2-tab">Imagem Secundária</a></li><?php */ ?>
							<?php if(isset($<ITEM_MODULO>) && $modulo->galeria){ ?>
								<li><a data-toggle="pill" href="#imagens-tab">Galeria</a></li>
							<?php } ?>
						</ul>
						<div class="spacer"></div>
						<form id="mainForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/<ROTA_MODULO>/save') }}">
						<div class="tab-content">
							
								<div id="info-tab" class="tab-pane fade in active">
									{{ csrf_field() }}
									<?php if($modulo->imagem){ ?>
										<input type="hidden" name="thumbnail_principal" value="<?php echo (isset($<ITEM_MODULO>)) ? $<ITEM_MODULO>->thumbnail_principal : ''; ?>">
									<?php } ?>
									<?php if(isset($<ITEM_MODULO>)){ ?>
										<input type="hidden" name="id" value="<?php echo $<ITEM_MODULO>->id; ?>"/>
									<?php } ?>
									<?php foreach($fields as $field){ ?>
										<?php $campo = $field->nome; ?>
										<div class="form-group">
											<label for="<?php echo $field->nome; ?>" class="col-md-3 control-label"><?php echo $field->label; ?> <?php echo ($field->required) ? '*' : ''; ?></label>

											<div class="col-md-7">
												<?php if($field->tipo_campo == 'I'){ ?>
													<input id="<?php echo $field->nome; ?>" <?php echo ($field->required) ? 'required' : ''; ?> type="text" class="form-control" value="<?php echo (isset($<ITEM_MODULO>)) ? $<ITEM_MODULO>->$campo : $field->valor_padrao; ?>" name="<?php echo $field->nome; ?>" />
												<?php } ?>
												<?php if($field->tipo_campo == 'N'){ ?>
													<input id="<?php echo $field->nome; ?>" <?php echo ($field->required) ? 'required' : ''; ?> type="number" class="form-control" value="<?php echo (isset($<ITEM_MODULO>)) ? $<ITEM_MODULO>->$campo : $field->valor_padrao; ?>" name="<?php echo $field->nome; ?>" />
												<?php } ?>
												<?php if($field->tipo_campo == 'T'){ ?>
													<textarea id="<?php echo $field->nome; ?>" <?php echo ($field->required) ? 'required' : ''; ?> class="form-control tinymce" name="<?php echo $field->nome; ?>"><?php echo (isset($<ITEM_MODULO>)) ? $<ITEM_MODULO>->$campo : $field->valor_padrao; ?></textarea>
												<?php } ?>
												<?php if($field->tipo_campo == 'D'){ ?>
													<input id="<?php echo $field->nome; ?>" <?php echo ($field->required) ? 'required' : ''; ?> type="date" class="form-control" value="<?php echo (isset($<ITEM_MODULO>)) ? $<ITEM_MODULO>->$campo : $field->valor_padrao; ?>" name="<?php echo $field->nome; ?>" />
												<?php } ?>
												<?php if($field->tipo_campo == 'DT'){ ?>
													<input id="<?php echo $field->nome; ?>" <?php echo ($field->required) ? 'required' : ''; ?> type="datetime" class="form-control" value="<?php echo (isset($<ITEM_MODULO>)) ? $<ITEM_MODULO>->$campo : $field->valor_padrao; ?>" name="<?php echo $field->nome; ?>" />
												<?php } ?>
											</div>
										</div>
									<?php } ?>
								</div>
							</form>
							<?php if($modulo->imagem){ ?>
								<div id="image-tab" class="tab-pane fade">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="image" class="col-md-3 control-label">Imagem</label>
											<div class="col-md-7">
												<form action="{{ url('admin/<ROTA_MODULO>/upload') }}" method="post" class="form single-dropzone" id="my-dropzone" enctype="multipart/form-data">
													<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
													<div id="img-thumb-preview">
														<img id="img-thumb" class="user size-lg img-thumbnail img-responsive" src="<?php echo (isset($<ITEM_MODULO>) && $<ITEM_MODULO>->thumbnail_principal != '') ? url('/uploads/<ROTA_MODULO>/'.$<ITEM_MODULO>->thumbnail_principal) : 'http://placehold.it/300x100'; ?>">
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
							<?php } ?>
							
							<?php if(isset($<ITEM_MODULO>) && $modulo->galeria){ ?>
							
								<div id="imagens-tab" class="tab-pane fade">
									<div class="col-lg-12 text-center">
										<a href="{{ url('admin/<ROTA_MODULO>/add_imagem/'.$<ITEM_MODULO>->id) }}" class="btn btn-success">
											Adicionar Imagem
										</a>
									</div>
									<div class="spacer"></div>
									<table id="list-data-table" class="table table-bordered table-striped">
	                                    <thead>
	                                        <tr>
	                                            <th>ID</th>
	                                            <th>Imagem</th>
	                                            <th>Ação</th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                        <?php foreach ($<ITEM_MODULO>->imagens as $imagem): ?>
	                                            <tr>
	                                                <td><?php echo $imagem->id; ?></td>
	                                                <td><img style="max-height:50px;" class="img-responsive" src="{{ url('uploads/<ROTA_MODULO>/'.$imagem->thumbnail_principal) }}" alt="Imagem Galeria"></td>
	                                                
	                                                <td><a href="/admin/<ROTA_MODULO>/edit_imagem/<?php echo $imagem->id; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a href="/admin/<ROTA_MODULO>/delete_imagem/<?php echo $imagem->id; ?>" class="btn btn-danger deletar"><i class="fa fa-trash"></i></a></td>
	                                               
	                                            </tr>
	                                        <?php endforeach ?>
	                                    </tbody>
	                                    <tfoot>
	                                        <tr>
	                                            <th>ID</th>
	                                            <th>Imagem</th>
	                                            <th>Ação</th>
	                                        </tr>
	                                    </tfoot>
	                                </table>
								</div>
							<?php } ?>
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
