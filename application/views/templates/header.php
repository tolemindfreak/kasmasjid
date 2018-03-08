<!doctype html>
<html class="no-js" lang="">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="manifest" href="site.webmanifest">
	<link rel="apple-touch-icon" href="<?php echo base_url();?>icon.png">
	<title>CodeIgniter Tutorial</title>
	<link rel="stylesheet" href="<?php echo base_url("assets/css/normalize.css");?>">
	<link rel="stylesheet" href="<?php echo base_url("assets/css/materialize.min.css");?>">
	<!--link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"-->
	<link href="<?php echo base_url("assets/css/icon.css");?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/main.css");?>">
    <script src="<?php echo base_url("assets/js/vendor/modernizr-3.5.0.min.js");?>"></script>
    <script src="<?php echo base_url("assets/js/jquery-3.3.1.min.js");?>"></script>
	<script src="<?php echo base_url("assets/js/materialize.min.js");?>"></script>
	<script src="<?php echo base_url("assets/js/chart.min.js");?>"></script>
	<script src="<?php echo base_url("assets/js/jQuery.print.min.js");?>"></script>
	<script src="<?php echo base_url("assets/js/pagination.js");?>"></script>
	<script src="<?php echo base_url("assets/js/autoNumeric.js");?>"></script>
	<script src="<?php echo base_url("assets/js/plugins.js");?>"></script>
	<script src="<?php echo base_url("assets/js/app.js");?>"></script>
    <script>
        window.jQuery || document.write('<script src="<?php echo base_url("assets/js/jquery-3.3.1.min.js");?>"><\/script>')
    </script>
</head>

<body class="hiddenOverflow">
	<div class="preload">
		<div class="preloader-wrapper big active centered">
			<div class="spinner-layer spinner-blue">
				<div class="circle-clipper left">
				<div class="circle"></div>
				</div><div class="gap-patch">
				<div class="circle"></div>
				</div><div class="circle-clipper right">
				<div class="circle"></div>
				</div>
			</div>

			<div class="spinner-layer spinner-red">
				<div class="circle-clipper left">
				<div class="circle"></div>
				</div><div class="gap-patch">
				<div class="circle"></div>
				</div><div class="circle-clipper right">
				<div class="circle"></div>
				</div>
			</div>

			<div class="spinner-layer spinner-yellow">
				<div class="circle-clipper left">
				<div class="circle"></div>
				</div><div class="gap-patch">
				<div class="circle"></div>
				</div><div class="circle-clipper right">
				<div class="circle"></div>
				</div>
			</div>

			<div class="spinner-layer spinner-green">
				<div class="circle-clipper left">
				<div class="circle"></div>
				</div><div class="gap-patch">
				<div class="circle"></div>
				</div><div class="circle-clipper right">
				<div class="circle"></div>
				</div>
			</div>
		</div>
	</div>

	<ul id="nav-mobile" class="side-nav fixed">
		<li class="logo">
			<a id="logo-container" class="brand-logo" href="#">
				<img id="front-page-logo" src="<?php echo base_url("assets/img/logo.png");?>" />
			</a>
		</li>
		<li>
			<div class="divider"></div>
		</li>
		<li>
			<a class="waves-effect" href="#!">
				<i class="material-icons">home</i>Dashboard</a>
		</li>
		<li style="margin-top:20px;">
			<a class="subheader">Menu</a>
		</li>
		<li>
			<a class="waves-effect" href="<?php echo base_url("index.php/kas");?>">
				Kas</a>
		</li>
		<li>
			<a class="waves-effect" href="<?php echo base_url("index.php/kas/totalkas/".date('m')."/".date('Y'));?>">
				Kas Per Bulan</a>
		</li>
		<li>
			<a class="waves-effect" href="<?php echo base_url("index.php/kas/kode");?>">
				Kode Kas</a>
		</li>
	</ul>

	<a href="#" data-activates="nav-mobile" class="menu-button button-collapse hide-on-large-only">
		<i class="material-icons">menu</i>
	</a>
