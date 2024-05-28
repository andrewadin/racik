<!doctype html>
<html lang="en">

<head>
<title>Racik @yield('title')</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Lucid Bootstrap 4x Admin Template">
<meta name="author" content="WrapTheme, design by: ThemeMakker.com">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">

<!-- MAIN CSS -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/blog.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/app.css')}}">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
@yield('css')
</head>
<body class="theme-cyan">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="{{asset('assets/images/logo.png')}}" width="87" height="26" alt="Lucid"></div>
        <p>Loading...</p>        
    </div>
</div>
<!-- Overlay For Sidebars -->

<div id="wrapper">

    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-btn">
                <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
            </div>

            <div class="navbar-brand">
                <a href="{{route('home')}}"><img src="{{asset('assets/images/logo.png')}}" alt="E-Rapor" class="img-responsive" style="width:80%;max-height:100%;"></a>                
            </div>
            
            <div class="navbar-right">               

                <div id="navbar-menu">
                    <ul class="nav navbar-nav">
                            <form action="{{ route('logout') }}" method="post">
                            @csrf
                                <button class="logout-btn btn btn-link icon-menu" type="submit"><i class="icon-login"></i></button>
                            </form>
                            <!-- <a href="{{ route('logout') }}" class="icon-menu"><i class="icon-login"></i></a> -->
                        </li>                        
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div id="left-sidebar" class="sidebar">
        <div class="sidebar-scroll">
            <div class="user-account">
                @if (Auth::user()->foto != NULL)
                <div class="profile-image"> <img src="{{ asset('images/' . Auth::user()->foto) }}" class="rounded-circle" alt="" style="width:25%; height:25%;"> </div>
                @else
                <div class="profile-image"> <img src="{{ asset('assets/images/user.png') }}" class="rounded-circle" alt="" style="width:25%; height:25%;"> </div>
                @endif
                <div class="dropdown">
                    <span>Welcome,</span>
                    <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>{{ Auth::user()->name }}</strong></a>                    
                    <ul class="dropdown-menu dropdown-menu-right account animated flipInY">
                        <li><a href="{{ '/profile' }}"><i class="icon-user"></i>Profil Saya</a></li>
                        <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li>
                        <li class="divider"></li>
                        <li>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                                <button class="btn btn-link icon-menu" type="submit"><i class="icon-power"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
                <hr>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#sub_menu"><i class="icon-grid"></i></a></li>                
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#setting"><i class="icon-settings"></i></a></li>
            </ul>
                
            <!-- Tab panes -->
            <div class="tab-content p-l-0 p-r-0">
                <div class="tab-pane animated fadeIn active" id="sub_menu">
                    <nav class="sidebar-nav">
                        <ul class="main-menu metismenu">
                        <li class="{{ (request()->is('konsumen*')) ? 'active' : '' }}"><a href="{{'/konsumen'}}"><i class="icon-users"></i> <span>Konsumen</span></a></li>
                        <li class="{{ (request()->is('paket*')) ? 'active' : '' }}"><a href="{{'/paket'}}"><i class="icon-drawer"></i> <span>Paket Catering</span></a></li>
                        <li class="{{ (request()->is('pesanan*')) ? 'active' : '' }}"><a href="{{'/pesanan'}}"><i class="icon-handbag "></i> <span>Pesanan</span></a></li>
                        </ul>
                    </nav>
                </div>
                <div class="tab-pane animated fadeIn" id="setting">
                    <div class="p-l-15 p-r-15">
                        <h6>Choose Skin</h6>
                        <ul class="choose-skin list-unstyled">
                            <li data-theme="purple">
                                <div class="purple"></div>
                                <span>Purple</span>
                            </li>                   
                            <li data-theme="blue">
                                <div class="blue"></div>
                                <span>Blue</span>
                            </li>
                            <li data-theme="cyan">
                                <div class="cyan"></div>
                                <span>Cyan</span>
                            </li>
                            <li data-theme="green">
                                <div class="green"></div>
                                <span>Green</span>
                            </li>
                            <li data-theme="orange" class="active">
                                <div class="orange"></div>
                                <span>Orange</span>
                            </li>
                            <li data-theme="blush">
                                <div class="blush"></div>
                                <span>Blush</span>
                            </li>
                        </ul>
                        <hr>
                        <h6>General Settings</h6>
                        <ul class="setting-list list-unstyled">
                            <li>
                                <label class="fancy-checkbox">
                                    <input type="checkbox" name="checkbox">
                                    <span>Report Panel Usag</span>
                                </label>
                            </li>
                            <li>
                                <label class="fancy-checkbox">
                                    <input type="checkbox" name="checkbox">
                                    <span>Email Redirect</span>
                                </label>
                            </li>
                            <li>
                                <label class="fancy-checkbox">
                                    <input type="checkbox" name="checkbox" checked>
                                    <span>Notifications</span>
                                </label>                      
                            </li>
                            <li>
                                <label class="fancy-checkbox">
                                    <input type="checkbox" name="checkbox" checked>
                                    <span>Auto Updates</span>
                                </label>
                            </li>
                            <li>
                                <label class="fancy-checkbox">
                                    <input type="checkbox" name="checkbox">
                                    <span>Offline</span>
                                </label>
                            </li>
                            <li>
                                <label class="fancy-checkbox">
                                    <input type="checkbox" name="checkbox" checked>
                                    <span>Location Permission</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>             
            </div>          
        </div>
    </div>
    @yield('content')
</div>

<!-- Javascript -->
<script src="{{asset('assets/bundles/libscripts.bundle.js')}}"></script>    
<script src="{{asset('assets/bundles/vendorscripts.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/mainscripts.bundle.js')}}"></script>
		
@stack('scripts')
@yield('scripts')
</body>
</html>