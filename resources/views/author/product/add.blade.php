
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ env('TITLE') }} - {{ env('TAG_LINE') }} </title>
<meta name="author" content="{{ env('AUTHOR') }}">
<meta name="description" content="{{ env('DESCRIPTION') }}">
<meta name="keywords" content="{{ env('KEYWORD') }}">

<!-- CSS Files -->
<link href="{{ asset('assets/customer/css/main.css') }}" rel="stylesheet">
<link href="{{ asset('assets/customer/css/bootstrap-tagsinput.css') }}" rel="stylesheet">

<!-- Bootstrap Select-->
<link rel="stylesheet" href="https://cdn.rawgit.com/infostreams/bootstrap-select/fd227d46de2afed300d97fd0962de80fa71afb3b/dist/css/bootstrap-select.min.css" />

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

         @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif  
	<div class="">
	<div class="formden_header">
		<h3 class="v-title">Add Product</h3>
	</div>
	<div class="create-account">
	<form role="form" method="POST" action="{{ route('author_add_product') }}" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

        <div class="form-group form-row">
			<label class="control-label Field" for="title">
			Title <span class="asteriskField">*</span></label>
			<input class="form-control" id="title" name="title" type="text" required>
		</div>

		

		<div class="form-group form-row">
			<label class="control-label Field" for="tag_line">
			Tag Line <span class="asteriskField"></span></label>
			<input class="form-control" id="tag_line" name="tag_line" type="text">
		</div>


		<div class="form-group form-row">
			<label class="control-label Field" for="categories">
			Categories <span class="asteriskField">*</span></label>
			<select class="form-control" name="category">
			  @foreach ($category as $data)
			  <option value="{{  $data->id }}">{{  $data->name }}</option>
			  @endforeach
			</select>
		</div>

		<br>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group form-row" style="border: 1px dotted gray; padding: 10px;">
					<label class="control-label Field">
					<b>Cover Image - Aspect Ration 3:2 - MIN: 1170x780 - MAX: 20MB (JPEG, PNG, SVG)</b> <span class="asteriskField">*</span></label>
					<input type="file" name="cover_image" required accept="image/*">
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group form-row" style="border: 1px dotted gray; padding: 22px;">
					<label class="control-label Field" for="zip_file">
					<b>Upload Item ZIP</b> <span class="asteriskField">*</span></label>
					<input type="file" name="zip_file" width="100%" required>
				</div>
			</div>
		</div>

		<div style="border: 1px dotted gray; padding: 4px;">
		<div class="row">
			<label style="padding-left: 10px;"> <b>Preview Images - Aspect Ration 3:2 - MIN: 570x380 - MAX: 5MB (JPEG, PNG, SVG)</b>	 </label></br>
			<div class="col-md-3">
				<div class="form-group form-row">
					<input type="file" name="preview_image_1" width="100%" accept="image/*">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group form-row">
					<input type="file" name="preview_image_2" width="100%" accept="image/*">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group form-row">
					<input type="file" name="preview_image_3" width="100%" accept="image/*">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group form-row">
					<input type="file" name="preview_image_4" width="100%" accept="image/*">
				</div>
			</div>
		</div>		
		</div>	
		<br>


		<!-- file type and requirement -->

		<div class="row">
			<div class="col-md-6">
				<div class="form-group form-row">
					<label class="control-label Field" for="file_type">
					File Type <span class="asteriskField">*</span></label><br>

					 <select class="selectpicker  show-tick" data-live-search="true" multiple name="file_type[]">
	                    @foreach ($file_type as $data)
	                    <option value="{{ $data->name_file_type }}">{{ $data->name_file_type }}</option>
	                    @endforeach
	                  </select>

				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group form-row">
					<label class="control-label Field" for="requirements">
					Requirements <span class="asteriskField">*</span></label><br>
					<select class="selectpicker show-tick" data-live-search="true" multiple name="requirements[]">
                      <option value="Adobe Photoshop">Adobe Photoshop</option>
                      <option value="Adobe Illustrator">Adobe Illustrator</option>
                      <option value="Adobe Lightroom">Adobe Lightroom</option>
                      <option value="Sketch">Sketch</option>
                   </select>
				</div>

			</div>
		</div>	

		<!-- tag -->
		<div class="form-group form-row">
					<label class="control-label Field" for="tag">
					Tag <span class="asteriskField"></span></label>
					<input class="form-control" id="tag" name="tag" type="text" >
		</div>


		<!-- text area  -->
		<label><b>Description</b></label>
		<textarea name="description" rows="6" maxlength="1000" class="form-control ckeditor" required></textarea>

		<br>
		<button type="submit" class="btn btn-primary">Add Product</button>

		</div>


    </form>
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
    <script src="{{ asset('assets/admin/ckeditor/ckeditor.js') }}" ></script>
    <script src="https://cdn.rawgit.com/infostreams/bootstrap-select/fd227d46de2afed300d97fd0962de80fa71afb3b/dist/js/bootstrap-select.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
	   $(window).keydown(function(event){
	     if(event.keyCode == 13) {
	       event.preventDefault();
	       return false;
	     }
	   });
	 });
    </script>

</body>
</html>
