<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Membership | {{ env('TITLE') }}</title>

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
                <!-- Navbar Brand --><a href="#" class="navbar-brand">
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
              <h2 class="no-margin-bottom">Membership </h2>
            </div>
          </header>
          <!-- Dashboard Counts Section-->
          <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">


              <div class="col-lg-12">
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
                            <ul style="list-style: none;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                  @endif  


                  <!-- personal information -->
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">{{ $membership->name }}'s Information</h3>
                    </div>
                    <div class="card-body">

                      <form class="" role="form" method="POST" action="{{ route('admin_membership_detail', ['id' => $membership->id]) }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                          
                        <div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="name">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $membership->name }}">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="email">Email</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="email" name="email" value="{{ $membership->email }}">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-sm-3 form-control-label">User Type</label>
                          <div class="col-sm-9">
                            <p>
                            @if ($membership->subscription_type == 1)
                            Free
                            @elseif ($membership->subscription_type == 2)
                            Monthly Premium
                            @else
                            Something Wrong
                            @endif
                            </p>
                          </div>
                        </div>
                          
                        <div class="form-group row" style="margin-top: -40px;">
                          <div class="col-sm-4 offset-sm-3">
                            <button type="submit" class="btn btn-primary">Edit Membership</button>
                          </div>
                        </div>
                        
                      </form>
                      
                    </div>
                  </div>
                  <!-- end personal information -->

                  <!-- list subscription -->
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Subscription History</h3>
                    </div>
                    <div class="card-body">

                        <table id="history-subscription" class="display" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th width="20%"><b>Date</b></th>
                                  <th width="50%"><b>Type</b></th>
                                  <th width="20%"><b>Expired</b></th>
                              </tr>
                          </thead>
                          <tbody>
                                 
                            @foreach ($subscription_history as $data)     
                            <tr>
                              
                               <td>{{ date("F d, Y", strtotime("$data->started_time_stamp")) }}</td>
                               <td>Premium Subscription Monthly ($9)</td>
                               <td>{{ date("F d, Y", strtotime("$data->started_time_stamp +1 month")) }}</td>
                              
                            </tr>
                            @endforeach

                          </tbody>
                        </table>
                                          
                    </div>
                  </div>
                  <!-- end list subscription -->


                  <!-- download history -->
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Download History</h3>
                    </div>
                    <div class="card-body">

                        <table id="history-download" class="display" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th width="60%"><b>Title</b></th>
                                  <th width="20%"><b>Category</b></th>
                                  <th width="20%"><b>Date</b></th>
                              </tr>
                          </thead>
                          <tbody>
                                 
                            @foreach ($downloads as $data)     
                            <tr>
                              
                               <td><a target="_blank" href="{{ route('view_product', ['slug_url' => $data->slug_url]) }}">{{ str_limit($data->title, $limit = 70, $end = '...') }}</a></td>
                               <td><a target="_blank" href="{{ route('category', ['category_slug' => $data->slug_name]) }}">{{ $data->name }}</a></td>
                               <td>{{ date("F d, Y", strtotime("$data->created_at")) }}</td>

                              
                            </tr>
                            @endforeach

                          </tbody>
                        </table>
                                          
                    </div>
                  </div>
                  <!-- end download history -->

              </div>


            </div>
          
          <!-- Page Footer-->
          @include('admin.partials.footer')
          <!-- end page footer -->

        </div>
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
    
    <!-- Data Table Plugins -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.js"></script>

    <script>
    $(document).ready(function(){
       $('#history-subscription').DataTable( {
             "columnDefs": [ {
                  "targets": 'no-sort',
                  "orderable": false,
            } ]
        } );
    });


    $(document).ready(function(){
       $('#history-download').DataTable( {
             "columnDefs": [ {
                  "targets": 'no-sort',
                  "orderable": false,
            } ]
        } );
    });
    </script>
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
    <!---->
  </body>
</html>