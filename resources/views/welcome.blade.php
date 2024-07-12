<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../assets/img/favicon2.ico" type="../assets/img/x-icon">

        <title>{{ config('app.name', 'HOLOS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link type="text/css" href="https://fonts.googleapis.com/css?family=Barlow:100,200,300,400,700" rel="stylesheet" />
            
        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('template/app-assets/css/bootstrap2.css')}}">
        <link rel="stylesheet" href="{{asset('template/app-assets/css/fonts.css')}}">
        <link rel="stylesheet" href="../template/app-assets/css/style.css" />
        
    </head>
    <body class="antialiased">
        <div class="page bg-image novi-background">
            <header class="section page-header">
                <div class="container">
                    <div class="row justify-content-between align-items-end row-30">
                      <div class="col-12 col-md-6"><a class="brand-logo" href="./"><img src="../img/logo-proyect.png" alt="" width="346" height="62"/></a></div>
                      <div class="col-12 col-md-6 col-xl-4">
                        <div class="head-title">
                            <button class="btn btn-info w-200"><a class="nav-link" href="login"><span>INICIAR SESION</span></a></button>
                          
                        </div>
                      </div>
                    </div>
                </div>
                <section class="section section-xs">
                    <div class="container">
                        <div class="tabs-custom tabs-horizontal tabs-corporate" id="tabs-1">
                            <div class="tab-pane fade show active" id="tabs-1-1">
                                <div class="tabs-custom tabs-horizontal tabs-gallery hide-on-modal" id="tabs-galery">
                                    <ul class="nav nav-tabs">
                                        <!--<li class="nav-item" role="presentation"><a class="nav-link" href="permiso/solicita" data-toggle="tab"><img src="../assets/img/permiso.jpg" alt="" width="180" height="180"/><span>PERMISO</span></a></li>-->
                                        <li class="nav-item" role="presentation"><a class="nav-link" href="permiso/solicita"><img src="{{asset('img/permiso.jpg')}}" alt="" width="180" height="180"/><span>PERMISO</span></a></li>
                                        <li class="nav-item" role="presentation"><a class="nav-link" href="anexo" ><img src="{{('img/anexos.jpg')}}" alt="" width="180" height="180"/><span>ANEXOS</span></a></li>
                                        <li class="nav-item" role="presentation"><a class="nav-link" href="{{route('cie10')}}" ><img src="{{('img/cie10black.jpg')}}" alt="" width="180" height="180"/><span>CIE 10</span></a></li>
                                        <li class="nav-item" role="presentation"><a class="nav-link" href="http://192.168.200.11/" target="_blank"><img src="{{('img/visorrx.jpg')}}" alt="" width="180" height="180"/><span>VISOR RX</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </header>
        </div>
        <footer class="section footer-classic context-dark novi-background">
            <div class="container">
                <div class="footer-group">
                    <ul class="list-inline list-inline-xs">
                    </ul>
                    <p class="rights"><span>&copy;&nbsp;</span><span class="copyright-year"></span><span>&nbsp;</span><span>.&nbsp;</span>Derechos reservados&nbsp;a&nbsp;<a href="/">HOLOS - HOSPITAL ALTO INCLAN</a></p>
                </div>
            </div>
        </footer>

    </body>
</html>
