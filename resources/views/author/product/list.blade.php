<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Account List Product - {{ env('TITLE') }} </title>
<meta name="author" content="{{ env('AUTHOR') }}">
<meta name="description" content="{{ env('DESCRIPTION') }}">
<meta name="keywords" content="{{ env('KEYWORD') }}">

<!-- CSS Files -->
<link href="{{ asset('assets/customer/css/main.css') }}" rel="stylesheet">

<style type="text/css">
.btn-danger {
    color: #fff;
    background-color: #d9534f;
    border-color: #d43f3a;
}

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
					    	<li class="menu-item"><a href="{{ route('author_profile') }}">Account</a></li>
							<li class="menu-item"><a href="{{ route('author_logout') }}">Logout</a></li>
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
								<li class="menu-item"><a href="{{ route('author_profile') }}">Profile</a></li>
								<li class="menu-item"><a href="{{ route('author_change_pwd') }}">Change Password</a></li>
								<li class="menu-item">|</li>
								<li class="menu-item"><a href="{{ route('author_list_product') }}">List Product</a></li>
								<li class="menu-item"><a href="{{ route('author_add_product') }}">Add Product</a></li>
								<li class="menu-item">|</li>
								<li class="menu-item"><a href="{{ route('author_report') }}">Reports</a></li>
							</ul><!-- .nav-menu -->
						</div>				
					</div>
				</div>
			</div>	
		</div><!-- .second-nav -->	<div class="site-content">
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
	<div class="">
	<div class="formden_header">
		<h3 class="v-title">List Products</h3>
	</div>
	<div class="create-account">

		<table class="table table-striped ">
                <thead>
                    <tr>
                        <th><b>Product</b></th>
                        <th><b>Date Add</b></th>
                        <th class="center"><b>Viewer</b></th>
                        <th class="center"><b>Action</b></th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($products as $data)		
                  <tr>
                     <td><a target="blank" href="">{{ $data->title }}</a></td>
                     <td>{{ date('d F Y', strtotime($data->created_at)) }}</td>
                     <td class="center viewer_account">{{ $data->viewer }}</td>
                     <td class="actions center">
                        <a href="{{ route('author_edit_product', ['id' => $data->id]) }}" data-toggle="tooltip" title="Change" class="btn btn-primary fa fa-gear" > edit</a>
                        <a href="{{ route('author_delete_product', ['id' => $data->id]) }}" onclick="return confirm('Are you sure want to delete?');" data-toggle="tooltip" title="Delete"  class="btn btn-danger btn-mini fa fa-trash-o"> delete</a>
                      </td>
                  </tr>
                  @endforeach
                 </tbody>
       </table>

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
