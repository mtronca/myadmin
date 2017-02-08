@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Busca Avançada
        <small>Resultados</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Gerador de Módulos</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
			 <?php if(isset($modulos) && count($modulos)){ ?>
				 <?php foreach ($modulos as $modulo): ?>
		          <div class="box">
		            <div class="box-header">
							<div class="text-center">
								<h3><?php echo $modulo['modulo']->label; ?></h3>
							</div>

		              <hr>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
		              <table id="list-data-table" class="table table-bordered table-striped">
		                <thead>
		                <tr>
		                  <th>ID</th>
								<?php foreach ($modulo['campos_listagem'] as $field): ?>
									<th><?php echo $field->label; ?></th>
								<?php endforeach ?>
		                  <th class="th-action">Ação</th>
		                </tr>
		                </thead>
		                <tbody>
								 <?php foreach ($modulo['registros'] as $item): ?>
								 	<tr>
								 		<td><?php echo $item->id; ?></td>
								 		<?php foreach ($modulo['campos_listagem'] as $field): ?>
								 			<?php $campo = $field->nome; ?>
								 			<td><?php echo $item->$campo; ?></td>
								 		<?php endforeach ?>
								 		<td>
											<a href="/admin/<?php echo $modulo['modulo']->rota; ?>/edit/<?php echo $item->id; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
								 			<a href="/admin/<?php echo $modulo['modulo']->rota; ?>/delete/<?php echo $item->id; ?>" class="btn btn-danger deletar"><i class="fa fa-trash"></i></a>
								 		</td>
								 	</tr>
								 <?php endforeach ?>
		                </tbody>
		                <tfoot>
		                <tr>
		                    <th>ID</th>
								  <?php foreach ($modulo['campos_listagem'] as $field): ?>
		  								<th><?php echo $field->label; ?></th>
		  							<?php endforeach ?>
		                    <th>Ação</th>
		                </tr>
		                </tfoot>
		              </table>
		            </div>
		            <!-- /.box-body -->
		          </div>
		          <!-- /.box -->
				  <?php endforeach; ?>
				<?php }else{ ?>
					<div class="box">
						<div class="box-header">
							<div class="text-center">
								<h3>Ops !</h3>
							</div>
							<hr>
						</div>
						<div class="box-body">
							<div class="text-center">
								<h4>Não foram encontrados registros para a sua busca.<h4>
							</div>
						</div>

						<div class="box-footer">

						</div>
					</div>

				<?php } ?>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
