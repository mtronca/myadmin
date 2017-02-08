<!DOCTYPE html>
<html lang="en">
<head>

	<title><?php echo $data['basic_info']->title;?></title>

	<base href="{{ url('') }}/"/>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="description" content="<?php echo (isset($meta_descricao)) ? $meta_descricao : $data['basic_info']->basic_meta_descricao;?>"/>
   <meta name="keywords" content="<?php echo (isset($meta_keywords)) ? $meta_keywords : $data['basic_info']->basic_meta_keywords;?>"/>

    <meta property="og:site_name" content="<?php echo $data['basic_info']->title; ?>"/>
    <meta property="og:title" content="<?php echo $data['basic_info']->basic_title; ?>"/>
    <meta property="og:description" content="<?php echo $data['basic_info']->basic_meta_descricao; ?>" />
    <meta property="og:image" content="{{ url('img/logo.png') }}"/>
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo \Request::url(); ?>"/>

	<!-- CSS's -->

</head>

<body>
	<header>
	    <!-- HEADER -->
	</header>


	@yield('content')



	<footer>
		<!-- FOOTER -->
	</footer>


    <!-- SCRIPTS's -->
</body>
</html>
