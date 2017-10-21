<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Membership - {{ env('TITLE') }} </title>
<meta name="author" content="{{ env('AUTHOR') }}">
<meta name="description" content="{{ env('DESCRIPTION') }}">
<meta name="keywords" content="{{ env('KEYWORD') }}">


<!-- CSS Files -->
<link href="{{ asset('assets/customer/css/main.css') }}" rel="stylesheet">

<style>



</style>
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
                        <ul class="nav-menu">
                            @if(Auth::guest())
                            <li class="menu-item"><a href="{{ route('subscriber_login') }}">Login</a></li>

                            @else
                            <li class="menu-item"><a href="{{ route('subscriber_account') }}">Hi, {{Auth::user()->name}}</a></li>
                            <li class="menu-item"><a href="{{ route('subscriber_logout') }}">Logout</a></li>

                            @endif 
                        </ul><!-- .nav-menu -->
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
                                <li class="menu-item"><a href="#">Chose Your Plan</a></li>
                            </ul><!-- .nav-menu -->
                        </div>              
                    </div>
                </div>
            </div>  
        </div><!-- .second-nav -->    <div class="site-content">
            <div class="container">

                <div class="content-inner product-plan">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="pricing-wrapper">
                                <div class="pricing-item">
                                    <header class="price-header">
                                        <h2>Free</h2>
                                        <div class="price">$0.00</div>
                                        <p>Per month update annually, no charge lifetime account</p>
                                    </header><!-- .pricing-header -->
                                    <div class="price-body">
                                        <ul class="pricing-features">
                                            <li><i class="fa fa-check" aria-hidden="true"></i>Unlimited Download</li>
                                            <li><i class="fa fa-check" aria-hidden="true"></i>Free Resources</li>
                                            <li><i class="fa fa-check" aria-hidden="true"></i>Commercial License</li>
                                            <li class="un-check">Premium Resources</li>
                                            <li class="un-check">Email Support</li>
                                        </ul><!-- .pricing-features -->
                                    </div><!-- .pricing-body -->
                                    <a href="{{ route('subscriber_register') }}?package=1" class="btn btn-primary">Get Started</a>
                                </div><!-- .pricing-item -->
                            </div><!-- .pricing-wrapper -->
                        </div>
                        <div class="col-md-4">
                            <div class="pricing-wrapper">
                                <div class="pricing-item">
                                    <header class="price-header">
                                        <h2>Monthly</h2>
                                        <div class="price">$9.00</div>
                                        <p>Per month billed annually or $108 from month to month</p>
                                    </header><!-- .pricing-header -->
                                    <div class="price-body">
                                        <ul class="pricing-features">
                                            <li><i class="fa fa-check" aria-hidden="true"></i>Unlimited Download</li>
                                            <li><i class="fa fa-check" aria-hidden="true"></i>Free Resources</li>
                                            <li><i class="fa fa-check" aria-hidden="true"></i>Commercial License</li>
                                            <li><i class="fa fa-check" aria-hidden="true"></i>Premium Resources</li>
                                            <li><i class="fa fa-check" aria-hidden="true"></i>Email Support</li>
                                        </ul><!-- .pricing-features -->
                                    </div><!-- .pricing-body -->
                                    <a href="{{ route('subscriber_register') }}?package=2" class="btn btn-primary">Get Started</a>
                                </div><!-- .pricing-item -->
                            </div><!-- .pricing-wrapper -->
                        </div>
                        <div class="col-md-4">
                            <div class="pricing-wrapper">
                                <div class="pricing-item">
                                    <header class="price-header">
                                        <h2>Year</h2>
                                        <div class="price">$6.00</div>
                                        <p>Per month billed annually or $72 from month to month</p>
                                    </header><!-- .pricing-header -->
                                    <div class="price-body">
                                        <ul class="pricing-features">
                                            <li><i class="fa fa-check" aria-hidden="true"></i>Unlimited Download</li>
                                            <li><i class="fa fa-check" aria-hidden="true"></i>Free Resources</li>
                                            <li><i class="fa fa-check" aria-hidden="true"></i>Commercial License</li>
                                            <li><i class="fa fa-check" aria-hidden="true"></i>Premium Resources</li>
                                            <li><i class="fa fa-check" aria-hidden="true"></i>Email Support</li>
                                        </ul><!-- .pricing-features -->
                                    </div><!-- .pricing-body -->
                                    <a href="{{ route('subscriber_register') }}?package=3" class="btn btn-primary">Get Started</a>
                                </div><!-- .pricing-item -->
                            </div><!-- .pricing-wrapper -->
                        </div>
                    </div>
                </div><!-- .product-plan -->



            </div>
        </div>
</main>
  
    <!-- END MAIN -->
    
    
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
