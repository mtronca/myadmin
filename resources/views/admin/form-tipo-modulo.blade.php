@extends('layouts.app')

@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo (isset($tipo)) ? 'Editar' : 'Criar'; ?>
			<small>Tipo de Módulo</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active"><?php echo (isset($tipo)) ? 'Editar' : 'Criar'; ?> Tipo de Módulo</li>
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
							<li><a data-toggle="pill" href="#controller-tab">Controller Admin</a></li>
							<li><a data-toggle="pill" href="#model-tab">Model</a></li>
							<li><a data-toggle="pill" href="#view-index-tab">View Admin Index</a></li>
							<li><a data-toggle="pill" href="#view-form-tab">View Admin Form</a></li>
							<li><a data-toggle="pill" href="#rotas-tab">Rotas</a></li>
						</ul>
						<div class="spacer"></div>
						<form id="mainForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/tipo-modulo/save') }}">
							<div class="tab-content">
								<div id="info-tab" class="tab-pane fade in active">
									{{ csrf_field() }}
									<?php if(isset($tipo)){ ?>
										<input type="hidden" name="id" value="<?php echo $tipo->id; ?>"/>
									<?php } ?>
									<div class="form-group">
										<label for="name" class="col-md-3 control-label">Nome</label>
										<div class="col-md-7">
											<input id="nome" type="text" class="form-control" value="<?php echo (isset($tipo)) ? $tipo->nome : ''; ?>" name="nome" />
										</div>
									</div>
								</div>
								<div id="controller-tab" class="tab-pane fade">
									<div class="form-group">
										<label for="name" class="col-md-3 control-label">Nome do Arquivo</label>
										<div class="col-md-7">
											<input id="controller_admin" value="<?php echo (isset($tipo)) ? $tipo->controller_admin : ''; ?>" type="text" class="form-control" name="controller_admin"/>
										</div>
									</div>
								</div>
								<div id="model-tab" class="tab-pane fade">
									<div class="form-group">
										<label for="name" class="col-md-3 control-label">Nome do Arquivo</label>
										<div class="col-md-7">
											<input id="model" value="<?php echo (isset($tipo)) ? $tipo->model : ''; ?>" type="text" class="form-control" name="model"/>
										</div>
									</div>
								</div>
								<div id="view-index-tab" class="tab-pane fade">
									<div class="form-group">
										<label for="name" class="col-md-3 control-label">Nome do Arquivo</label>
										<div class="col-md-7">
											<input id="view_admin_index" value="<?php echo (isset($tipo)) ? $tipo->view_admin_index : ''; ?>" type="text" class="form-control" name="view_admin_index"/>
										</div>
									</div>
								</div>
								<div id="view-form-tab" class="tab-pane fade">
									<div class="form-group">
										<label for="name" class="col-md-3 control-label">Nome do Arquivo</label>
										<div class="col-md-7">
											<input id="view_admin_form" value="<?php echo (isset($tipo)) ? $tipo->view_admin_form : ''; ?>" type="text" class="form-control" name="view_admin_form"/>
										</div>
									</div>
								</div>
								<div id="rotas-tab" class="tab-pane fade">
									<div class="form-group">
										<label for="name" class="col-md-3 control-label">Nome do Arquivo</label>
										<div class="col-md-7">
											<input id="rotas" value="<?php echo (isset($tipo)) ? $tipo->rotas : ''; ?>" type="text" class="form-control" name="rotas"/>
										</div>
									</div>
								</div>
							</div>
						</form>
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
