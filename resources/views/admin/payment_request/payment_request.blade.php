
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Payment Request</title>

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
              <h2 class="no-margin-bottom">Payment Request</h2>
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


                  <div class="card">
                    <div class="card-body">
                      
                      
                      <table id="partcipants" class="display" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th class="no-sort center">REF</th>
                              <th class="center">Author</th>
                              <th class="center">Email</th>
                              <th class="center">Amount</th>
                              <th class="center">Request</th>
                              <th class="no-sort center">Action</th>
                              <th class="center">Status</th>
                            </tr>
                          </thead>
                         <tbody>
                           @foreach ($author_withdrawal as $data)         
                           <tr>
                            <td class="center"><b>#{{ $data->ref }}</b></td>
                            <td class="center">{{ $data->name }}</td>
                            <td class="center">{{ $data->email }}</td>
                            <td class="center"><b>${{ $data->amount }}</b></td>
                            <td class="center">{{ date("M d, Y H:m:s", strtotime("$data->created_at")) }}</td>
                            <td class="actions center">
                              @if ($data->status == 1)
                              <a href="{{ route('admin_pay_request', ['id' => $data->id]) }}" data-toggle="tooltip" title="Pay Request" class="btn btn-primary btn-mini"> Pay</a>          
                              <a href="" data-toggle="tooltip" title="Pay Request" class="btn btn-danger btn-mini"> Calcel</a>          
                              @elseif ($data->status == 2)
                              <a data-toggle="tooltip" title="Already Paid"  class="btn btn-danger btn-mini"> Pay</a>          
                              @else
                              <td class="center">Something Wrong</td>
                              @endif
                            </td>

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
       $('#partcipants').DataTable( {
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