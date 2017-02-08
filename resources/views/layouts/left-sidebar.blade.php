<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="{{ (Auth::user()->thumbnail_principal != '') ? 'uploads/users/'.Auth::user()->thumbnail_principal : 'img/user2-160x160.jpg' }}" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p>{{ Auth::user()->name }}</p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>
		<!-- search form -->
		<form action="{{ url('admin/busca') }}" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
					<button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
					</button>
				</span>
			</div>
		</form>
		<!-- /.search form -->
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li class="header">MAIN NAVIGATION</li>
			<li>
				<a href="{{ url('/admin') }}">
					<i class="fa fa-files-o"></i>
					<span>Dashboard</span>
					<span class="pull-right-container">
						<!--<span class="label label-primary pull-right">4</span>-->
					</span>
				</a>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-th"></i> <span>Módulos</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<?php foreach($data['modulos'] as $modulo){ ?>
						<li ><a href="{{ url('admin/'.$modulo->rota) }}"><i class="fa fa-circle-o"></i><?php echo $modulo->label; ?></a></li>
					<?php } ?>
				</ul>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-cog"></i>
					<span>Configurações</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="{{ url('admin/informacoes-basicas') }}"><i class="fa fa-circle-o"></i> Informações Básicas Website</a></li>
					<?php if(Auth::user()->id_user_group == 1){ ?>
						<li><a href="{{ url('admin/gerador') }}"><i class="fa fa-circle-o"></i> Gerador de Módulos</a></li>
						<li><a href="{{ url('admin/tipo-modulo') }}"><i class="fa fa-circle-o"></i> Tipos de Módulos</a></li>
						<li><a href="{{ url('admin/users') }}"><i class="fa fa-circle-o"></i> Usuários</a></li>
						<li><a href="{{ url('admin/users-groups') }}"><i class="fa fa-circle-o"></i> Grupos de Usuário</a></li>
					<?php } ?>

				</ul>
			</li>
			<li>
				<a href="{{ url('') }}">
					<i class="fa fa-share"></i>
					<span>Site</span>
					<span class="pull-right-container">
						<!--<span class="label label-primary pull-right">4</span>-->
					</span>
				</a>
			</li>

		</ul>
	</section>
	<!-- /.sidebar -->
</aside>
