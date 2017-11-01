
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Forgot Password | {{ env('TITLE') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('assets/administrator/css/bootstrap.min.css') }}">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('assets/administrator/css/style.default.css') }}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
     <link rel="stylesheet" href="{{ asset('assets/administrator/css/custom.css') }}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('assets/administrator/img/favicon.ico') }}">
    <!-- Font Awesome CDN-->
    <!-- you can replace it by local Font Awesome-->
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Font Icons CSS-->
    <!-- <link rel="stylesheet" href="https://file.myfontastic.com/da58YPMQ7U5HY8Rb6UxkNf/icons.css"> -->
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

  </head>
  <body>
    <div class="page login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info d-flex align-items-center">
                <div class="content">
                  <div class="logo">
                    <h1>{{ env('TITLE') }}</h1>
                  </div>
                  <p>{{ env('TAG_LINE') }}</p>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                
                <!-- SHOW ERROR -->
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

                <!-- END SHOW ERROR -->
                  <form id="login-form" method="post" method="POST" action="{{ route('admin_forgot_password') }} ">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <div class="form-group">
                      <input id="login-username" type="text" name="email" required="" class="input-material">
                      <label for="login-username" class="label-material">Email</label>
                    </div>
                    <button  type="submit" class="btn btn-primary">Recovery Password</button> 

                    <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                    
                  </form><br>
                  <small>Do you want Sign In? </small><a href="{{ route('admin_login') }}" class="signup">SignIn</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copyrights text-center">
        <p>{{ env('TITLE') }} &copy; {{ date("Y") }}</p>
        <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
      </div>
    </div>
    
    <!-- Javascript files-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="{{ asset('assets/administrator/js/tether.min.js') }}"></script>
    <script src="{{ asset('assets/administrator/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/administrator/js/jquery.cookie.js') }}"> </script>
    <script src="{{ asset('assets/administrator/js/jquery.validate.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="{{ asset('assets/administrator/js/charts-home.js') }}"></script>
    <script src="{{ asset('assets/administrator/js/front.js') }}"></script>
    

    
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
    <!---->
    
  </body>
</html>