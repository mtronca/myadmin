@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Visualizar Usuario</div>
                <div class="panel-body">
                    <div class="spacer"></div>
                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Nome:</label>
                        <div class="col-md-6">
                            <input id="nome" type="text" readonly class="form-control" name="nome" value="<?php echo (isset($user)) ? $user->name : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-md-4 control-label">E-mail:</label>
                        <div class="col-md-6">
                            <input id="nome" type="text" class="form-control" name="email" readonly value="<?php echo (isset($user)) ? $user->email : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Criado em:</label>
                        <div class="col-md-6">
                            <input id="nome" type="text" readonly class="form-control" name="create_at" value="<?php echo (isset($user)) ? date('d/m/Y',strtotime($user->created_at)) : ''; ?>">
                        </div>
                    </div>
                      <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Grupo:</label>
                        <div class="col-md-6">
                            <input id="nome" type="text" readonly class="form-control" name="create_at" value="<?php echo (isset($user) && $user->userGroup) ? $user->userGroup->nome : ''; ?>">
                        </div>
                    </div>
            
                </div>
                <div class="panel-footer">
 
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
