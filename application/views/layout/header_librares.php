<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" type="image/png" href="<?= base_url();?>assets/dist/img/vortex.png"/>
  <title>Vortex</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url();?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url();?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url();?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->

  <!-- --------------------------- -->
  <link rel="stylesheet" href="<?= base_url();?>assets/dist/css/AdminLTE.min.css"> 
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?= base_url();?>assets/dist/css/skins/_all-skins.min.css">

  <!-- ------------------------- -->



  <!-- Morris chart -->
  <link rel="stylesheet" href="<?= base_url();?>assets/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?= base_url();?>assets/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?= base_url();?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url();?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?= base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style type="text/css">
    *{
      margin: 0;
      padding: 0;
    }
    body{
      background: #F0F0F0;
    }
    .head{
      width: 100%;
      line-height: 40px;
      background: #00c0ef; /* #008080 */
      box-shadow: 1px 1px 2px black;
      z-index: 10;
      position: fixed;
      text-shadow: 1px 1px 1px #000;
    }
    
    h2{
      color:#ffffff;
      text-align: center;
      font-family: sans-serif;
      text-shadow: 2px 2px 2px #000;
    }
    .conte{
      margin-top:80px;
    }
    @media screen and (max-width: 1400px){
      h2{
        font-size: .8em;
      }

    }
  </style>
    <style type="text/css">
    a.enl{
      position: fixed;
      right: 0;
      width: 45px;
      line-height: 45px;
      border-radius: 5px 0 0 5px;
      color: #fff;
      text-align: center;
      font-family: sans-serif;
      z-index: 100000;
    }
    a.enlace_atras{
      top:45%;
    }
    a.enlace_home {
      top:55%;
    }
    a.enlace_atras img,a.enlace_home img{
      width: 100%;
      height: 100%;
      opacity: .5;
      border-radius: 5px 0 0 5px;
    }
  </style>

</head>
<body>
  <a class="enl enlace_atras" href="javascript:history.back(-1);"><img src="<?=base_url();?>assets/dist/img/atras.png" alt="Atras"></a>
  <a class="enl enlace_home" href="http://172.17.200.106/vortex/"><img src="<?=base_url();?>assets/dist/img/inicio.png" alt="Inicio"></a>
<!-- <body class="hold-transition skin-blue sidebar-mini"> -->
<div class="wrapper">
