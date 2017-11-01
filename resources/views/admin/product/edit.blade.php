<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $product->title }} | {{ env('TITLE') }}</title>

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

    <!--  FOTORAMA Files -->
    <link  href="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet"> <!-- 3 KB -->

    <!-- Bootstrap Select-->
     <link rel="stylesheet" href="https://cdn.rawgit.com/infostreams/bootstrap-select/fd227d46de2afed300d97fd0962de80fa71afb3b/dist/css/bootstrap-select.min.css" />

    <style type="text/css">
  .fotorama__caption {
    text-align: center;
  }

  .fotorama__caption__wrap {
    border-radius: 1.5px;
  }

  /*
Make bootstrap-select work with bootstrap 4 see:
https://github.com/silviomoreto/bootstrap-select/issues/1135
*/
.dropdown-toggle.btn-default {
  color: #292b2c;
  background-color: #fff;
  border-color: #ccc;
}
.bootstrap-select.show > .dropdown-menu > .dropdown-menu,
.bootstrap-select > .dropdown-menu > .dropdown-menu li.hidden {
  display: block;
}
.bootstrap-select > .dropdown-menu > .dropdown-menu li a {
  display: block;
  width: 100%;
  padding: 3px 1.5rem;
  clear: both;
  font-weight: 400;
  color: #292b2c;
  text-align: inherit;
  white-space: nowrap;
  background: 0 0;
  border: 0;
  text-decoration: none;
}
.bootstrap-select > .dropdown-menu > .dropdown-menu li a:hover {
  background-color: #f4f4f4;
}
.bootstrap-select > .dropdown-toggle {
  width: auto;
}
.dropdown-menu > li.active > a {
  color: #fff !important;
  background-color: #337ab7 !important;
}
.bootstrap-select .check-mark {
  line-height: 14px;
}
.bootstrap-select .check-mark::after {
  font-family: "FontAwesome";
  content: "\f00c";
}
.bootstrap-select button {
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 390px;
}

/* Make filled out selects be the same size as empty selects */
.bootstrap-select.btn-group .dropdown-toggle .filter-option {
  display: inline !important;
}

</style>

    
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
              <h2 class="no-margin-bottom">Edit Product</h2>
            </div>
          </header>
          <!-- Dashboard Counts Section-->
          <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">

              <!-- content -->
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
                   

                  <div class="card">
                    <div class="card-body">
                     
                      <form class="" role="form" method="POST" action="{{ route('admin_edit_product', ['id' => $product->id]) }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

                            <div class="form-group form-row">
                              <label class="control-label requiredField" for="title">
                              Title <span class="asteriskField">*</span></label>
                              <input class="form-control" id="title" name="title" type="text" value="{{ $product->title }}" required>
                        </div>

                        

                        <div class="form-group form-row">
                          <label class="control-label requiredField" for="tag_line">
                          Tag Line <span class="asteriskField"></span></label>
                          <input class="form-control" id="tag_line" name="tag_line" type="text" value="{{ $product->tag_line }}">
                        </div>


                        <div class="form-group form-row">
                          <label class="control-label requiredField" for="categories">
                          Categories <span class="asteriskField">*</span></label>
                          <select class="form-control" name="category">
                            @foreach ($category as $data)
                            <option value="{{  $data->id }}" @if($data->id == $product->category) selected @endif>{{  $data->name }}</option>
                            @endforeach
                          </select>
                        </div>

                        <br>


                        <div class="row">
                          <div class="col-md-6">
                            <!-- Fotorama Image Slide -->

                            <div class="fotorama" >
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

                            <!-- END Fotorama Image Slide --> 
                          </div>
                          <div class="col-md-6" style="padding: 40px">
                             <p>Ensure you mention anything shown in the preview not included in the main .zip and note if any main element is rasterized, outlined or otherwise not editable.</p>
                             <a href="{{ Storage::url('zip_file/') }}{{ $product->zip_file }}" class="btn btn-success btn-lg">
                                <span class="fa fa-download"></span> Download Item ZIP 
                              </a>  
                          </div>
                        </div>

                        <div class="clear" style=""></div>   

                        <div class="row" style="padding: 0px 0px">
                          <div class="col-md-6">
                            <div class="form-group form-row" style="border: 1px dotted gray; padding: 10px;">
                              <label class="control-label requiredField">
                              Cover Image - Aspect Ration 3:2 - MIN: 1170x780 - MAX: 20MB (JPEG, PNG, SVG)</b> <span class="asteriskField">*</span></label>
                              <input type="file" name="cover_image">
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group form-row" style="border: 1px dotted gray; padding: 20px;">
                              <label class="control-label requiredField" for="zip_file">
                              <b>Upload Item ZIP</b> <span class="asteriskField">*</span></label>
                              <input type="file" name="zip_file" width="100%">
                            </div>
                          </div>
                        </div>

                        <div style="border: 1px dotted gray; padding: 0px;">
                        <h5 style="padding: 10px;">Preview Images - Aspect Ration 3:2 - MIN: 570x380 - MAX: 5MB (JPEG, PNG, SVG)</h5>
                        <div class="row" style="padding: 0px 0px">
                          <div class="col-md-3">
                            <div class="form-group form-row">
                              <input type="file" name="preview_image_1" width="100%">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group form-row">
                              <input type="file" name="preview_image_2" width="100%">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group form-row">
                              <input type="file" name="preview_image_3" width="100%">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group form-row">
                              <input type="file" name="preview_image_4" width="100%">
                            </div>
                          </div>
                        </div>    
                        </div>  
                        <br>


                        <!-- file type and requirement -->



                        <div class="row" style="padding: 0px 0px; margin-left: -14px;">
                          
                          <div class="col-md-6">
                            <div class="form-group form-row">
                              <label class="control-label requiredField" for="file_type">
                              File Type <span class="asteriskField">*</span></label><br>

                              <select class="selectpicker  show-tick" data-live-search="true" multiple name="file_type[]" title="{{ $product->file_type }}">
                                @foreach ($file_type as $data)
                                <option value="{{ $data->name_file_type }}">{{ $data->name_file_type }}</option>
                                @endforeach
                              </select>

                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group form-row">
                              <label class="control-label requiredField" for="requirements">
                              Requirements <span class="asteriskField">*</span></label><br>
                               <select class="selectpicker  show-tick" data-live-search="true" multiple name="requirements[]" title="{{ $product->requirements }}" >
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
                              <label class="control-label requiredField" for="tag">
                              Tag (Maximum of 20 keyword )<span class="asteriskField"></span></label>
                              <input class="form-control" id="tag" name="tag" type="text" value="{{ $product->tag }}">
                        </div>


                        <!-- text area  -->
                        <label><b>Description</b></label>
                        <textarea name="description" rows="6" maxlength="1000" class="form-control ckeditor">{{ $product->description }}</textarea>

                        <br>
                        <button type="submit" class="btn btn-primary">Edit Product</button>

                        </div>


                        </form>

                    </div>
                  </div>
                </div>
              <!-- end content -->


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

    <script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script> <!-- 16 KB -->
    <script src="{{ asset('assets/admin/ckeditor/ckeditor.js') }}" ></script>
    <script src="https://cdn.rawgit.com/infostreams/bootstrap-select/fd227d46de2afed300d97fd0962de80fa71afb3b/dist/js/bootstrap-select.min.js"></script>

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