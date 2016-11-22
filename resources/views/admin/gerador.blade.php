@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Gerador 
        <small>de Módulos</small>
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
          
          <div class="box">
            <div class="box-header">
              <a href="{{ url('admin/gerador/add') }}" class="table-add"><i class="fa fa-plus"></i> Adicionar</a>
              <hr>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="list-data-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Título</th>
                  <th>Rota</th>
                  <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($modulos as $modulo): ?>
                    <tr>
                      <td><?php echo $modulo->id; ?></a></td>
                      <td><?php echo $modulo->title; ?></a></td>
                      <td><?php echo $modulo->rota; ?></a></td>
                      <td><a href="/admin/gerador/edit/<?php echo $modulo->id; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                          <a href="/admin/gerador/delete/<?php echo $modulo->id; ?>" class="btn btn-danger deletar"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Rota</th>
                    <th>Ação</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <a href="{{ url('admin/gerador/add') }}" class="table-add"><i class="fa fa-plus"></i> Adicionar</a>
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

