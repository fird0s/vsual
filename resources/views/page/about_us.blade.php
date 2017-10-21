<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> About Us - {{ env('TITLE') }} </title>
<meta name="author" content="{{ env('AUTHOR') }}">
<meta name="description" content="{{ env('DESCRIPTION') }}">
<meta name="keywords" content="{{ env('KEYWORD') }}">

<!-- CSS Files -->
<link href="{{ asset('assets/customer/css/main.css') }}" rel="stylesheet">
</head>
</body>
    <div class="wrapper">
    <header class="site-header" role="banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="site-logo"><a href="{{ route('home') }}" class="logo-text">Vsual</a></div><!-- .site-logo -->
                <nav class="site-navigation">
                    <div class="menu-container">
                        <ul class="nav-menu">
                            <li class="menu-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="menu-item"><a href="{{ route('page_membership') }}">Membership</a></li>
                            <li class="menu-item"><a href="{{ route('page_about_us') }}">About</a></li>
                            <li class="menu-item"><a href="{{ route('page_license') }}">License</a></li>
                        </ul><!-- .nav-menu -->
                    </div>
                </nav><!-- .site-navigation -->

                <nav class="site-navigation user-nav">
                    <div class="menu-container">
                       @if(Auth::guest())
                            <li class="menu-item"><a href="{{ route('subscriber_login') }}">Login</a></li>

                            @else
                            <li class="menu-item"><a href="{{ route('subscriber_account') }}">Hi, {{Auth::user()->name}}</a></li>
                            <li class="menu-item"><a href="{{ route('subscriber_logout') }}">Logout</a></li>

                            @endif
                    </div>
                </nav><!-- .user-navigation -->

                </div>
            </div>
        </div>

        <div class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-title">Page Title</h1>
                        <div class="page-subtitle">Auctor quam habitasse diam egestas pretium tortor purus inceptos mi proin. </div>
                    </div>
                </div>
            </div>
        </div><!-- .page-header -->
    </header><!-- .site-header -->

    <!-- MAIN  -->

    <main class="site-main" role="main">
  <div class="second-nav">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="account-menu-container">
            <ul class="nav-menu">
              <li class="menu-item"><a href="about.html">About Us</a></li>
              <li class="menu-item"><a href="our-team.html">Our Team</a></li>
            </ul><!-- .nav-menu -->
          </div>
        </div>
      </div>
    </div>
  </div><!-- .second-nav -->
 
    <div class="site-content">
            <div class="container">
                <div class="content-inner p-60">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="content-left p-right-40">
                                <h2>About Us</h2>
                                <p class="font-alt">Habitasse aenean sit. Sagittis amet etiam potenti praesent quis. Facilisis phasellus mi nascetur risus ornare ridiculus magnis ipsum non penatibus erat sem lacinia litora varius felis eros lobortis pretium mauris urna mi dictum at lectus.</p>

                                <p>acinia libero Malesuada volutpat porttitor eros mi. Suscipit cursus dolor lorem vo lupat, varius condimentum aptent sit posuere nullam vel id nonummy id quis eleme ntum dis tortor malesuada odio egestas gravida egestas tortor duis semper cras nulla dictum euismod platea. Dui elementum porta, sodales interdum facilisi.</p>

                                <p>A turpis montes Praesent senectus tempor.Rhoncus litora. Vestibulum etiam semp er fringilla aliquam ut tincidunt tristique, accumsan phasellus mus lacus luctus pro in Ut hymenaeos. Tellus eu hendrerit potenti aliquet luctus libero metus mauris sociis turpis velit. Et a lacinia libero Malesuada volutpat porttitor eros mi.</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <aside class="sidebar">
                                <h2>Support</h2>
                                <p>Can’t find an answer you were looking for? Contact Support and we’ll be able to assist you.</p>
                                <a href="#" class="btn btn-primary">Contact Support</a>
                                <ul class="follow-icons list-inline">
                                    <li class="follow-facebook">
                                        <a href="#"><span class="fa fa-facebook facebk fa-i"></span></a>
                                    </li>
                                    <li class="follow-twitter">
                                        <a href="#"><span class="fa fa-twitter fa-i"></span></a>
                                    </li>
                                    <li class="follow-google-plus">
                                        <a href="#"><span class="fa fa-google-plus fa-i"></span></a>
                                    </li>
                                    <li class="follow-instagram">
                                        <a href="#"><span class="fa fa-instagram fa-i"></span></a>
                                    </li>
                                </ul><!-- .follow-icons -->
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    
    <footer class="site-footer">
    <div class="footer-widget">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="site-logo">
                        <a href="#" class="logo-text">Vsual</a>
                    </div><!-- .site-logo -->

                    <div class="row">
                        <div class="col-xs-12">
                                <ul class="follow-icons list-inline">
                                    <li class="follow-facebook">
                                        <a href="#"><span class="fa fa-facebook facebk fa-i"></span></a>
                                    </li>
                                    <li class="follow-twitter">
                                        <a href="#"><span class="fa fa-twitter fa-i"></span></a>
                                    </li>
                                    <li class="follow-google-plus">
                                        <a href="#"><span class="fa fa-google-plus fa-i"></span></a>
                                    </li>
                                    <li class="follow-instagram">
                                        <a href="#"><span class="fa fa-instagram fa-i"></span></a>
                                    </li>
                                </ul><!-- .follow-icons -->
                            </div>
                        </div>

                    </div>

                    <div class="col-md-2">
                        <div class="menu-footer-container">
                            <ul id="menu-footer" class="menu">
                                <li class="menu-item"><a href="#">About</a></li>
                                <li class="menu-item"><a href="#">Our Store</a></li>
                                <li class="menu-item"><a href="#">Contact</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="menu-footer-container">
                            <ul id="menu-footer" class="menu">
                                <li class="menu-item"><a href="#">Privacy</a></li>
                                <li class="menu-item"><a href="#">Terms</a></li>
                                <li class="menu-item"><a href="#">License</a></li>
                            </ul>
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="menu-footer-container">
                            <ul id="menu-footer" class="menu">
                                <li class="menu-item"><a href="#">FAQ's</a></li>
                                <li class="menu-item"><a href="#">Affiliate</a></li>
                                <li class="menu-item"><a href="#">Career</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <h6 class="footer-heading-p">Subscribe</h6>
                        <form class="footer_form" method="post">
                            <div class="form-group">
                                <input type="text" id="email" class="form-control" placeholder="Enter your email here">
                                <span class="material-input"></span><span class="material-input"></span>
                                <span class="material-input"></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- .footer-widget -->

        <div class="footer-copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p class="copyright">2016 Vsual, All right reserved</p>
                    </div>
                </div>
            </div>
        </div><!-- .footer-widget -->
    </footer>
    <!-- .site-footer -->
    </div><!--end of wrapper-->
    <!-- JS Files -->
    <script src="{{ asset('assets/customer/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/customer/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/customer/js/owl.carousel.js') }}"></script>
</body>
</html>
