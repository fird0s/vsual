
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Admin</title>

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

    <!-- Data Tables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.css"/>

    
  </head>
  <body>
    <div class="page home-page">
      <!-- Main Navbar-->
      <header class="header">
        <nav class="navbar">
          <!-- Search Box-->
          <div class="search-box">
            <button class="dismiss"><i class="icon-close"></i></button>
            <form id="searchForm" action="#" role="search">
              <input type="search" placeholder="What are you looking for..." class="form-control">
            </form>
          </div>
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <!-- Navbar Header-->
              <div class="navbar-header">
                <!-- Navbar Brand --><a href="http://conference.ccmanager.pl/index.php/administrator/statistics" class="navbar-brand">
                  <div class="brand-text brand-big hidden-lg-down"><span>Administrator</strong></div>
                  <div class="brand-text brand-small"><strong>Admin</strong></div></a>
                <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
              </div>
              <!-- Navbar Menu -->
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <!-- Logout    -->
                <li class="nav-item">
                  <a href="{{ route('admin_logout') }}" class="nav-link logout">Logout<i class="fa fa-sign-out"></i>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <div class="page-content d-flex align-items-stretch">

       <!-- Side Navbar -->
       @include('admin.partials.sidebar')
       <!-- end Side Navbar -->

        <div class="content-inner">
          <!-- Page Header-->
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Add Author</h2>
            </div>
          </header>
          <!-- Dashboard Counts Section-->
          <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">

              <!-- add form -->

              <div class="col-lg-12">
                 
                 @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="list-style: none;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                  @endif  

                  <div class="card">
                    <div class="card-body">
                      <form action="{{ route('admin_author_add') }}" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        
                        
                        <div class="line"></div>
                        <div class="form-group">
                          <label class="form-control-label" for="name">Name</label>
                          <input type="text" placeholder="Name" name="name" id="name" class="form-control">
                        </div>

                        <div class="form-group">
                          <label class="form-control-label" for="email">Email</label>
                          <input type="text" placeholder="Email" name="email" id="email" class="form-control">
                        </div>

                        <label class="form-control-label">Set Password</label>
                        <div class="form-group row" style="padding: 0px 0px; margin-left: -14px;">
                          <div class="col-sm-4 form-control-label">
                            <input type="text" placeholder="password" name="password" class="form-control">
                          </div>
                          <div class="col-sm-5">
                            <a style="cursor:pointer" class="btn btn-info generate_password">Generate Password</a>
                          </div>
                        </div>


                        <hr>
                        <div class="line"></div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add Author</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

              <!-- end add form -->

            </div>
          
          <!-- Page Footer-->
          @include('admin.partials.footer')
          <!-- end page footer -->

        </div>
      </div>
    </div>
    <!-- Javascript files-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="http://conference.ccmanager.pl/static/js/tether.min.js"></script>
    <script src="http://conference.ccmanager.pl/static/js/bootstrap.min.js"></script>
    <script src="http://conference.ccmanager.pl/static/js/jquery.cookie.js"> </script>
    <script src="http://conference.ccmanager.pl/static/js/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="http://conference.ccmanager.pl/static/js/charts-home.js"></script>
    <script src="http://conference.ccmanager.pl/static/js/front.js"></script>
    
    <!-- Data Table Plugins -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.js"></script>

    <script type="text/javascript">
      $( ".generate_password" ).click(function() {
        var pwd = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 9);
        $("input[name='password']").val(pwd);
      });
    </script>

    <script>
    $(document).ready(function(){
       $('#list-products').DataTable( {
             "columnDefs": [ {
                  "targets": 'no-sort',
                  "orderable": false,
            } ]
        } );
    });
    </script>

    <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
    </script>
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
    <!---->
  </body>
</html>