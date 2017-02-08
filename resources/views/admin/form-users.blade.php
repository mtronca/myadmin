@extends('layouts.app')

@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo (isset($user)) ? 'Editar' : 'Criar'; ?>
			<small>Informações Usuário</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ url('/admin/users') }}">Usuários</a></li>
			<li class="active"><?php echo (isset($user)) ? 'Editar' : 'Criar'; ?></li>
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
							<?php if(isset($user)){ ?>
								<li><a data-toggle="pill" href="#image-tab">Imagem</a></li>
							<?php } ?>
						</ul>
						<div class="spacer"></div>
						<form id="mainForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/users/save') }}">
						<div class="tab-content">

								<div id="info-tab" class="tab-pane fade in active">
									{{ csrf_field() }}

									<input type="hidden" name="thumbnail_principal" value="<?php echo (isset($user)) ? $user->thumbnail_principal : ''; ?>">
									<?php if(isset($user)){ ?>
										<input type="hidden" name="id" value="<?php echo $user->id; ?>"/>
									<?php } ?>

									<div class="form-group">
										<label for="name" class="col-md-3 control-label">Nome</label>

										<div class="col-md-7">
											<input id="name" type="text" class="form-control" value="<?php echo (isset($user)) ? $user->name : ''; ?>" name="name" />
										</div>
									</div>

									<div class="form-group">
										<label for="email" class="col-md-3 control-label">E-mail</label>

										<div class="col-md-7">
											<input id="email" type="text" class="form-control" value="<?php echo (isset($user)) ? $user->email : ''; ?>" name="email" />
										</div>
									</div>

									<div class="form-group">
										<label for="password" class="col-md-3 control-label">Senha</label>

										<div class="col-md-7">
											<input id="password" type="password" class="form-control" value="" name="password" />
										</div>
									</div>
									<?php if(isset($user) && $user->id_user_group != 1){ ?>
										<input type="hidden" name="id_user_group" value="<?php echo $user->id_user_group; ?>">
									<?php }else{ ?>
									<div class="form-group">
										<label for="id_user_group" class="col-md-3 control-label">Grupo do Usuário</label>

										<div class="col-md-7">
											<select id="id_user_group" class="form-control" name="id_user_group">
												<?php foreach ($listaUserGroup as $userGroup): ?>
													<?php if(isset($user) && $user->id_user_group == $userGroup->id){ $selected = 'selected'; }else{ $selected = ''; } ?>
													<option <?php echo $selected; ?> value="<?php echo $userGroup->id; ?>"><?php echo $userGroup->nome; ?></option>
												<?php endforeach ?>
											</select>
										</div>
									</div>
									<?php } ?>
								</div>


							</form>
							<?php if(isset($user)){ ?>
								<div id="image-tab" class="tab-pane fade">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="image" class="col-md-3 control-label">Imagem</label>
											<div class="col-md-7">
												<form action="{{ url('admin/users/upload') }}" method="post" class="form single-dropzone" id="my-dropzone" enctype="multipart/form-data">
													<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
													<div id="img-thumb-preview">
														<img id="img-thumb" class="user size-lg img-thumbnail img-responsive" src="<?php echo (isset($user) && $user->thumbnail_principal != '') ? url('/uploads/users/'.$user->thumbnail_principal) : 'http://placehold.it/300x100'; ?>">
													</div>
													<button type="button" style="display:none;" id="crop-image" class="btn btn-success">Salvar Corte</button>
													<button id="upload-submit" class="btn btn-default margin-t-5"><i class="fa fa-upload"></i> Upload Picture</button>
												</form>
												<form class="hidden" action="{{ url('admin/users/crop') }}" id="cropForm" method="POST">
													<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
													<input type="hidden" name="data_crop">
													<input type="hidden" name="file_name">
												</form>
											</div>
										</div>
									</div>
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
