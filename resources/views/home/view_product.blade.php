<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> {{ $product->title }}  - {{ env('TITLE') }} </title>
<meta name="author" content="{{ env('AUTHOR') }}">
<meta name="description" content="{{ env('DESCRIPTION') }}">
<meta name="keywords" content="{{ env('KEYWORD') }}">

<!-- CSS Files -->
<link href="{{ asset('assets/customer/css/main.css') }}" rel="stylesheet">

<style>

.product-info .add-to-cart{
    text-align: center;
    font-weight: bold;
}

</style>

<!--  FOTORAMA Files -->
<link  href="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet"> <!-- 3 KB -->

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


    


    <!-- main site -->

    <main class="site-main" role="main">
    <div class="site-content">
        <div class="container">
            <div class="content-inner">
                <div class="row">
                    <div class="col-md-8">
                        <div class="fotorama" data-nav="thumbs" data-arrows="false">
                          @if ($product->cover_image) 
                          <img src="{{ Storage::url('cover_image/') }}{{ $product->cover_image}}">
                          @endif
                          @if ($product->preview_image_1) 
                          <img src="{{ Storage::url('preview_image/') }}{{ $product->preview_image_1 }}">    
                          @endif
                          @if ($product->preview_image_2) 
                          <img src="{{ Storage::url('preview_image/') }}{{ $product->preview_image_2 }}">    
                          @endif
                          @if ($product->preview_image_3) 
                          <img src="{{ Storage::url('preview_image/') }}{{ $product->preview_image_3 }}">    
                          @endif
                          @if ($product->preview_image_4) 
                          <img src="{{ Storage::url('preview_image/') }}{{ $product->preview_image_4 }}">    
                          @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="product-info">
                            
                                <h5> {{ $product->title }}</h5>

                            <ul class="product-meta">
                                
                                @if ($product->tag_line) 
                                <h6> {{ $product->tag_line }}</h6>
                                @endif
                                
                                @if ($product->file_type) 
                                <li>
                                    <span>File Types : </span>{{ $product->file_type }}
                                </li>
                                @endif

                                @if ($product->requirements) 
                                <li>
                                    <span>Requirements : </span>
                                        {{ $product->requirements }}
                                </li>
                                @endif

                                @if ($product->tag) 
                                <li>
                                    <span>Tags: {{ $product->tag }} </span>
                                </li>
                                @endif
                                
                            </ul>

                                 @if(Auth::guest())
                                 <div>
                                    <h5 class="center">Subscribe to unclock this item</h5>
                                    <a href="{{ route('page_membership') }}" class="btn btn-primary add-to-cart">ENJOY UNLIMITED DOWNLOAD</a><br><br>
                                    <p class="center">Already have membership account ? <a href="{{ route('subscriber_login') }}"><br><b>Sign In here</b></a></a>
                                 </div>

                                 @elseif ($product->free == 1 && Auth::user())
                                 <a href="{{ Storage::url('zip_file/') }}{{ $product->zip_file}}" class="btn btn-primary add-to-cart">Download</a>                                 
                                 @elseif (Auth::user()->subscription_type == 2)
                                 <a href="{{ Storage::url('zip_file/') }}{{ $product->zip_file}}" class="btn btn-primary add-to-cart record">Download</a>
                                 @elseif (Auth::user()->subscription_type == 3)
                                 <a href="{{ Storage::url('zip_file/') }}{{ $product->zip_file}}" class="btn btn-primary add-to-cart record">Download</a>
                                 
                                 @else
                                 <div>
                                    <h5 class="center">Subscribe to unclock this item</h5>
                                    <a href="{{ route('page_membership') }}" class="btn btn-primary add-to-cart">ENJOY UNLIMITED DOWNLOAD</a><br><br>
                                 </div>
                                 @endif

                            </div>
                        </div>
                    </div>

                    <div class="clear"></div>

                    <div class="col-md-8" style="margin-top: 10px;">

                        <!-- <h2 class="title">Detail Information</h2> -->
                        <div class="text-content short-text">
                            {!! $product->description !!}
                        </div>
                    </div>

                </div>

                <div class="content-related">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>You might also like</h3>
                        </div>
                        <div class="col-md-4">
                            <div class="product-item">
                                <figure class="product-thumb">
                                    <a href="#">
                                            <img src="">
                                    </a>
                                </figure>
                                <div class="product-body">
                                    <div class="product-title">
                                        <a href="#">Wine Packaging Mockups</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="product-item">
                                <figure class="product-thumb">
                                    <a href="#">
                                            <img src="">
                                    </a>
                                </figure>
                                <div class="product-body">
                                    <div class="product-title">
                                        <a href="#">Wine Packaging Mockups</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="product-item">
                                <figure class="product-thumb">
                                    <a href="#">
                                            <img src="">
                                    </a>
                                </figure>
                                <div class="product-body">
                                    <div class="product-title">
                                        <a href="#">Wine Packaging Mockups</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .content-related -->

            </div>



        </div>
</main>


    <!-- end main site -->
    
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
    <script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script> <!-- 16 KB -->

    <script type="text/javascript">
        $(".record").click(function(){
            $.get( "/download/{{ $product->slug_url}}", function( data ) {
              console.log(data);
            });
        });

    </script>
</body>
</html>
