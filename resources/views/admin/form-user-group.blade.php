@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo isset($userGroup) ? 'Editar' : 'Adicionar'; ?>
        <small>Grupo de Usuario</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('admin/users-group') }}"> Grupos de Usuário</a></li>
        <li class="active"><?php echo isset($userGroup) ? 'Editar' : 'Adicionar'; ?> </li>
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
                      <form id="mainForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/users-groups/save') }}">
                            {{ csrf_field() }}
                            <?php if(isset($userGroup)){ ?>
                              <input type="hidden" name="id" value="<?php echo $userGroup->id; ?>"/>
                            <?php } ?>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Nome</label>

                                <div class="col-md-6">
                                    <input id="nome" type="text" class="form-control" name="nome" value="<?php echo (isset($userGroup)) ? $userGroup->nome : ''; ?>">
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
