@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Tables
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Usuários</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @if(\Session::has('type') && \Session::has('message'))            
            <div class="session-return-wrapper">
                <div class="session-return-{{ \Session::get('type') }}">
                    {{ \Session::get('message') }}
                    <i class="fa fa-times"></i>
                </div>
            </div>
      @endif
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="list-data-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>Grupo de Usuário</th>
                  <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($listaUser as $user): ?>
                    <tr>
                      <td> <?php echo $user->name; ?></td>
                      <td> <?php echo ($user->userGroup) ? $user->userGroup->nome : 'None'; ?></td>
                      <td>
                        <a href="/admin/users/view/<?php echo $user->id; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                        <a href="/admin/users/delete/<?php echo $user->id; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Nome</th>
                    <th>Grupo de Usuário</th>
                    <th>Ação</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
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

