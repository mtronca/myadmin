<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Project</title>

    <base href="{{ url('') }}/"/>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->


    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <!-- Taggle JS -->
    <link rel="stylesheet" href="{{ url('plugins/taggle/example/css/taggle.css') }}">
    <link rel="stylesheet" href="{{ url('css/admin/cropper.min.css') }}">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ url('css/admin/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('css/admin/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ url('css/admin/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/admin/style.css') }}">

    <script type="text/javascript" src="{{ url('js/admin/cropper.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/admin/dropzone.js') }}"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
    <!-- Pickadate.JS -->
    <link rel="stylesheet" href="{{ url('plugins/pickadate/lib/themes/default.css') }}">
    <link rel="stylesheet" href="{{ url('plugins/pickadate/lib/themes/default.date.css') }}">
    <script src="{{ url('plugins/pickadate/lib/picker.js') }}"></script>
    <script src="{{ url('plugins/pickadate/lib/picker.date.js') }}"></script>
  
    <!-- Taggles JS -->
    <script src="{{ url('plugins/taggle/src/taggle.js') }}"></script>

</head>

<body class="hold-transition skin-blue fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    @include('layouts.notification')
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  @include('layouts.left-sidebar')
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  @if(\Session::has('type') && \Session::has('message'))
    <div class="alerta alerta-{{ \Session::get('type') }}">
      <div class="wrap-icone">
        <i class="icone fa fa-exclamation"></i>
      </div>
      <div class="text">
        <span class="titulo">{{ \Session::get('message') }}</span>
        <span></span>
      </div>
      <a href="#" class="fecha-alerta"><i class="fa fa-times"></i></a>
    </div>    
  @endif
  
  @yield('content')

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.6
    </div>
    <strong>Copyright &copy; 2014-2016.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  @include('layouts.control-sidebar')
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="{{ url('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- TinyMCE -->
<script src="{{ url('plugins/tinymce/tinymce.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ url('js/admin/bootstrap.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ url('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ url('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ url('plugins/fastclick/fastclick.js') }}"></script>
<!-- Input-masks -->
<script src="{{ url('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ url('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ url('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('js/admin/app.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('js/admin/demo.js') }}"></script>
<!-- iCheck -->
<script src="{{ url('plugins/iCheck/icheck.min.js') }}"></script>
<!-- Custom scripts -->
<script src="{{ url('js/admin/scripts.js') }}"></script>
</body>
</html>