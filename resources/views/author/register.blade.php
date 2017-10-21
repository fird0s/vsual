<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Register Author | {{ env('TITLE') }} </title>
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
                        <ul class="nav-menu">
                                                        <li class="menu-item"><a href="{{ route('subscriber_login') }}">Login</a></li>
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
                                <!-- <li class="menu-item"><a href="{{ route('page_membership') }}">Chose Your Plan</a></li> -->
                            </ul><!-- .nav-menu -->
                        </div>              
                    </div>
                </div>
            </div>  
        </div><!-- .second-nav -->  <div class="site-content">
    <div class="container">
    <div class="content-inner checkout-account p-60">
    <div class="row vertical-divider">
        @if (Session::has('success'))
        <div class="alert alert-success">
          {{Session::get('success')}}
        </div>
        @endif
        @if (Session::has('error'))
        <div class="alert alert-danger">
          {{Session::get('error')}}
        </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif  
    <div class="col-md-6 col-sm-6 col-xs-12 padding-right">
    <div class="formden_header">
        <h3 class="v-title">Author Sign Up</h3>
    </div>
    <div class="create-account">

        <form method="POST" action="{{ route('author_register') }}" accept-charset="UTF-8">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <div class="form-group form-row">
                <label class="control-label requiredField" for="name">
                Full Name <span class="asteriskField">*</span></label>
                <input class="form-control" id="name" name="name" type="text">
            </div>

            <div class="form-group form-row">
                <label class="control-label requiredField" for="name">
                Username <span class="asteriskField">*</span></label>
                <input class="form-control" id="name" name="username" type="text">
            </div>

            <div class="form-group form-row">
                <label class="control-label requiredField" for="email">
                    Email Address<span class="asteriskField">*</span>
                </label>
                <input class="form-control" id="email" name="email" type="text">
            </div>

            <div class="form-group form-row">
                <label class="control-label requiredField" for="password">
                    Password<span class="asteriskField">*</span>
                </label>
                <input class="form-control" id="password" name="password" type="password">
                            </div>

            <!-- Confirm password -->
            <div class="form-group form-row">
                <label class="control-label requiredField" for="password">
                    Confirm Password<span class="asteriskField">*</span>
                </label>
                <input class="form-control" id="password-confirm" name="password_confirmation" type="password">
                            </div>

            <!-- Select type of payment -->
            

            <div class="clear"></div>

             <div class="form-group">
                Already have membership account ? <a href="{{ route('author_login') }}"><b>Sign In here</b></a>
             </div>

            <div class="form-group">
                <button type="submit" name="register_btn"class="btn btn-primary">
                    <i class="fa fa-btn fa-user"></i> Register as Author
                </button>
            </div>

        </form>
    </div>

    </div>
    
    <div class="col-md-6 col-sm-6 col-xs-12 padding-left">
        <div class="formden_header">
            <h3 class="v-title">Earn Money with Us</h3>
                <div class="payment-method">
                    <div class="payment-type"></div>
                    <div class="gap"></div>
                    <p>
                        Authors to Vsual share in 50% of the net revenue from subscriptions. We allocate this as fairly as possible, using the “subscriber share” method. 
                        <br><br>

                        With subscriber share your earnings as an author are directly linked to the money collected from each individual subscriber. We look at each subscriber in turn, and assign you a share of 50% of their net revenue based on how important your items were to them (calculated from your share of all item they used in that period)

                    </p>
                </div>
        </div>
    </div>
    
    </div>
    </div><!-- .account-inner -->
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
