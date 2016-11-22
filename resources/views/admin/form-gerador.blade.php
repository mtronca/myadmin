@extends('layouts.app')

@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo (isset($modulo)) ? 'Editar' : 'Criar'; ?>
			<small>Módulo</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active"><?php echo (isset($modulo)) ? 'Editar' : 'Criar'; ?> Módulo</li>
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
						</ul>
						<div class="spacer"></div>
						<div class="tab-content">
							<div id="info-tab" class="tab-pane fade in active">
								<form id="mainForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/gerador/save') }}">
									{{ csrf_field() }}
									<?php if(isset($modulo)){ ?>
										<input type="hidden" name="id" value="<?php echo $modulo->id; ?>"/>
									<?php } ?>
									<div class="form-group">
										<label for="label" class="col-md-3 control-label">Label</label>

										<div class="col-md-7">
											<input id="label" type="text" class="form-control" value="<?php echo (isset($modulo)) ? $modulo->label : ''; ?>" name="label" />
										</div>
									</div>
									<div class="form-group">
										<label for="name" class="col-md-3 control-label">Nome</label>
										<div class="col-md-7">
											<input id="nome" type="text" class="form-control" value="<?php echo (isset($modulo)) ? $modulo->nome : ''; ?>" name="nome" />
										</div>
									</div>
									<div class="form-group">
										<label for="name" class="col-md-3 control-label">Rota</label>
										<div class="col-md-7">
											<input id="rota" type="text" class="form-control" value="<?php echo (isset($modulo)) ? $modulo->rota : ''; ?>" name="rota" />
										</div>
									</div>
									<div class="form-group">
										<label for="item_modulo" class="col-md-3 control-label">Item do Módulo</label>
										<div class="col-md-7">
											<input id="item_modulo" type="text" class="form-control" value="<?php echo (isset($modulo)) ? $modulo->item_modulo : ''; ?>" name="item_modulo" />
										</div>
									</div>
									
									<div class="form-group">
										<label for="items_modulo" class="col-md-3 control-label">Itens do Módulo</label>
										<div class="col-md-7">
											<input id="items_modulo" type="text" class="form-control" value="<?php echo (isset($modulo)) ? $modulo->items_modulo : ''; ?>" name="items_modulo" />
										</div>
									</div>
									<div class="form-group">
										<label for="nome_tabela" class="col-md-3 control-label">Nome da tabela</label>
										<div class="col-md-7">
											<input id="nome_tabela" type="text" class="form-control" value="<?php echo (isset($modulo)) ? $modulo->nome_tabela : ''; ?>" name="nome_tabela" />
										</div>
									</div>
									<div class="form-group">
										<label for="imagem" class="col-md-3 control-label">Imagem</label>
										<div class="col-md-7">
											<input id="imagem" type="checkbox" value="1" <?php echo (isset($modulo) && $modulo->imagem) ? 'checked' : ''; ?> name="imagem" />
										</div>
									</div>
									<div class="form-group">
										<label for="galeria" class="col-md-3 control-label">Galeria</label>
										<div class="col-md-7">
											<input id="galeria" type="checkbox" value="1" <?php echo (isset($modulo) && $modulo->galeria) ? 'checked' : ''; ?> name="galeria" />
										</div>
									</div>
									<div class="form-group">
										<label for="name" class="col-md-3 control-label">Tipo</label>
										<div class="col-md-7">
											<select name="id_tipo_modulo" id="id_tipo_modulo" class="form-control">
												<?php foreach ($tipos as $tipo): ?>
													<?php if(isset($modulo) && $tipo->id == $modulo->id_tipo_modulo){ $selected = 'selected'; }else{ $selected = ''; } ?>
													<option <?php echo $selected; ?> value="<?php echo $tipo->id; ?>"><?php echo $tipo->nome; ?></option>
												<?php endforeach ?>
											</select>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<div class="text-center">
							<button type="submit" class="btn btn-primary">
								<i class="fa fa-btn fa-pencil"></i> <?php echo (isset($modulo))? 'Salvar' : 'Gerar'; ?>
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
