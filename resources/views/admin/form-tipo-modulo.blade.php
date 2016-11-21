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
						</ul>
						<div class="spacer"></div>
						<div class="tab-content">
							<div id="info-tab" class="tab-pane fade in active">
								<form id="mainForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/tipo-modulo/save') }}">
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
									
								</form>
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
