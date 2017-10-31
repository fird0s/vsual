
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Author Detail</title>

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
              <h2 class="no-margin-bottom">Author </h2>
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
                        <h3 class="h4">{{ $author->name }}'s Information</h3>
                    </div>
                    <div class="card-body">

                      <form class="" role="form" method="POST" action="{{ route('admin_author_detail', ['id' => $author->id]) }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        <div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="name">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $author->name }}">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="email">Email</label>
                          <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email" value="{{ $author->email }}">
                          </div>
                        </div>

                        
                        <div class="form-group row" style="margin-top: -40px;">
                          <div class="col-sm-4 offset-sm-3">
                            <button type="submit" class="btn btn-primary">Edit author</button>
                          </div>
                        </div>
                        
                      </form>
                      
                    </div>
                  </div>
                  <!-- end personal information -->


                  <!-- list revenue -->
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Author Revenue</h3>
                    </div>
                    <div class="card-body">

                        <table id="author-revenue" class="display" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th width="15%"><b>Revenue</b></th>
                                  <th width="50%"><b>Subscriber</b></th>
                                  <th width="15%"><b>Date Expired</b></th>
                                  <!-- <th width="20%"><b>Status</b></th> -->
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($author_revenue as $revenue)         
                              <tr>
                                <td>{{ $revenue->revenue }}</td>
                                <td>{{ $revenue->name }}</td>
                                <td>{{ date("M d, Y", strtotime("$revenue->subscription_ends_time_stamp")) }}</td>
                               <!--  @if ($revenue->status == 1)
                                <td class="center">Ongoing</td>
                                @elseif ($revenue->status == 2)
                                <td class="center">Expired</td>
                                @elseif ($revenue->status == 3)
                                <td class="center">Calculated</td>
                                @else
                                <td class="center">Something Wrong</td>
                                @endif -->
                              </tr>
                              @endforeach  
                          </tbody>
                        </table>
                                          
                    </div>
                  </div>
                  <!-- end list revenue -->

                  <!-- list withdraw -->
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Withdraw History</h3>
                    </div>
                    <div class="card-body">

                        <table id="history-withdraw" class="display" cellspacing="0" width="100%">
                          <thead>
                              
                              <tr>
                                  <th width="15%"><b>REF</b></th>
                                  <th width="15%"><b>Date Request</b></th>
                                  <th width="15%"><b>Amount</b></th>
                                  <th class="center" width="25%"><b>Status</b></th>
                              </tr>
                              
                          </thead>
                          <tbody>

                            @foreach ($author_withdrawal as $data)         
                            <tr>
                                <td><b>#{{ $data->ref }}</b></td>  
                                <td>{{ date("M d, Y - H:m", strtotime("$data->created_at")) }}</td>
                                <td>${{ $data->amount }}</td>
                                @if ($data->status == 1)
                                <td class="center">Unpaid</td>
                                @elseif ($data->status == 2)
                                <td class="center">Already Paid</td>
                                @else
                                <td class="center">Something Wrong</td>
                                @endif
                            </tr>  
                            @endforeach  
                            

                          </tbody>
                        </table>
                                          
                    </div>
                  </div>
                  <!-- end list withdraw -->


                  <!-- author product  -->
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Author Product</h3>
                    </div>
                    <div class="card-body">

                        <table id="author-product" class="display" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th class="no-sort">Title</th>
                              <th>Date</th>
                              <th class="no-sort"> Category</th>
                              <th class="no-sort"> Action</th>
                            </tr>
                          </thead>
                         <tbody>
                           @foreach ($product as $data)         
                           <tr>
                            <td><a target="blank" href="{{ route('view_product', ['slug_url' => $data->slug_url]) }}" data-toggle="tooltip" title="{{ $data->title }}">{{ str_limit($data->title, $limit = 30, $end = '...') }}</a></td>
                            <td>{{ date("M d, Y - H:m", strtotime("$data->created_at")) }}</td>
                            <td>{{ $data->category_name }}</td>
                            <td class="actions center">
                               <a href="{{ route('admin_edit_product', ['id' => $data->id]) }}" data-effect="mfp-move-from-top"  data-toggle="tooltip" title="edit product"  class="btn btn-primary btn-mini"> edit</a>          
                               <a href="http://conference.ccmanager.pl/index.php/administrator/delete_participant/28" onclick="return confirm('Are you sure deleted this participant?');" data-effect="mfp-move-from-top" data-toggle="tooltip" title="delete product"  class="btn btn-danger btn-mini"> delete</a>          
                            </td>
                          </tr>
                          @endforeach  

                         </tbody>
                       </table>
                                          
                    </div>
                  </div>
                  <!-- end author product -->

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
    <script src="http://conference.ccmanager.pl/static/js/tether.min.js"></script>
    <script src="http://conference.ccmanager.pl/static/js/bootstrap.min.js"></script>
    <script src="http://conference.ccmanager.pl/static/js/jquery.cookie.js"> </script>
    <script src="http://conference.ccmanager.pl/static/js/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="http://conference.ccmanager.pl/static/js/charts-home.js"></script>
    <script src="http://conference.ccmanager.pl/static/js/front.js"></script>
    
    <!-- Data Table Plugins -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.js"></script>

    <script>
    $(document).ready(function(){
       $('#history-withdraw').DataTable( {
             "columnDefs": [ {
                  "targets": 'no-sort',
                  "orderable": false,
            } ]
        } );
    });


    $(document).ready(function(){
       $('#author-product').DataTable( {
             "columnDefs": [ {
                  "targets": 'no-sort',
                  "orderable": false,
            } ]
        } );
    });

    $(document).ready(function(){
       $('#author-revenue').DataTable( {
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