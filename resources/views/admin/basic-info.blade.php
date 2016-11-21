@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Editar
        <small>Informações Website</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Informações Website</li>
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
                                <form id="mainForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/informacoes-basicas/save') }}">
                                    {{ csrf_field() }}
                                    <?php if(isset($info)){ ?>
                                      <input type="hidden" name="id" value="<?php echo $info->id; ?>"/>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label for="name" class="col-md-3 control-label">Title</label>

                                        <div class="col-md-7">
                                            <input id="title" type="text" class="form-control" value="<?php echo $info->title; ?>" name="title"/>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label for="basic_meta_keywords" class="col-md-3 control-label">Palavras Chave</label>

                                        <div class="col-md-7">
                                            <div id="basic_meta_keywords"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="basic_meta_descricao" class="col-md-3 control-label">Meta Descrição</label>

                                        <div class="col-md-7">
                                            <textarea id="basic_meta_descricao" type="text" class="form-control" name="basic_meta_descricao"><?php echo (isset($info)) ? $info->basic_meta_descricao : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <script>
                                        new Taggle('basic_meta_keywords', {
                                            <?php if(isset($info) && $info->basic_meta_keywords != ''){ ?>
                                                tags: [
                                                    <?php $tags = explode(',',$info->basic_meta_keywords); ?>
                                                    <?php foreach($tags as $tag){ ?>                
                                                        '<?php echo $tag; ?>',
                                                    <?php } ?>
                                                ],
                                            <?php } ?>
                                            duplicateTagClass: 'bounce'
                                        });
                                    </script>
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
@endsection
