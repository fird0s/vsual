<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> {{ env('TITLE') }} - {{ env('TAG_LINE') }} </title>
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

    <main class="site-main" role="main">
    <div class="second-nav">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="account-menu-container">

          <ul class="nav-menu">
            <li class="menu-item"><a href="#">Recent</a></li>
            <li class="menu-item"><a href="#">Popular</a></li>
            <li class="menu-item"><a href="#">Free</a></li>
          </ul><!-- .nav-menu -->

          <form method="post" class="search-product pull-right">
            <div class="form-group ">
              <input class="form-control" id="search" name="search" type="text" placeholder="Search" />
              <i class="fa fa-search"></i>
            </div>
          </form> <!-- .search-product -->

        </div>
      </div>
    </div>
  </div>
</div><!-- .second-nav -->
    <div class="site-content">
        <div class="container">
            <div class="content-inner product">
                <div class="row">

                    <!-- Looping Product -->
                    @foreach ($products as $data)       
                    <div class="col-md-4">
                        <div class="product-item">
                          <figure class="product-thumb">
                            <a href="{{ route('view_product', ['slug_url' => $data->slug_url]) }}">
                              <img src="{{ Storage::url('cover_image/') }}{{ $data->cover_image}}" style="height: 200px;">
                            </a>

                          </figure>
                          <div class="product-body">
                            <div class="product-title">
                              <a href="{{ route('view_product', ['slug_url' => $data->slug_url]) }}">{{ str_limit($data->title, $limit = 35, $end = '...') }}</a>
                            </div>
                            <div class="product-meta">
                              <span class="product-cat"><a href="{{ route('category', ['category_slug' => $data->slug_name]) }}">{{ $data->name }}</a></span>
                              <span class="product-date">{{ date("M d, Y", strtotime("$data->created_at")) }} </span>
                            </div>
                          </div>
                        </div>
                    </div>  
                    @endforeach  


                    <div class="row">
                        <div class="col-md-12">
                            <nav role="navigation">
                                <ul class="vs-pagination">
                                    <li class="button"><a class="disabled" href="#">Prev</a></li>
                                    <li><a class="current" href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><span>...</span></li>
                                    <li><a href="#">20</a></li>
                                    <li class="button"><a href="#">Next</a></li>

                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main><!-- .site-main -->
    
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
