 <nav class="side-navbar">
          <div class="sidebar-header d-flex align-items-center">
            <div class="avatar">
              @if ($admin->photo_profile)
              <img src="{{ Storage::url('admin/profile/') }}{{ $admin->photo_profile}}" alt="Photo Profile" class="img-fluid rounded-circle"></div>
              @else
              <img src="{{ Storage::url('admin/profile/no_image_user.png') }}" alt="Photo Profile" class="img-fluid rounded-circle"></div>
              @endif
            <div class="title">
              <h1 class="h4">{{ $admin->name }}</h1>
              <a href="{{ route('admin_profile_edit') }}">Profile</a>
            </div>
          </div>

          <br>

          <span class="heading">Main</span>  
          <ul class="list-unstyled">
            <li> 
              <a href="{{ route('admin_dashboard') }}"><i class="fa fa-line-chart">
              </i>Dashboard</a>
            </li>

            <li> 
              <a href="{{ route('admin_payment_request') }}"><i class="fa fa-credit-card">
              </i>Payout Request</a>
            </li>

            <li> 
              <a href="{{ route('admin_membership') }}"><i class="fa fa-sitemap"></i>Membership</a>
            </li>

            <li> <a href="{{ route('admin_product') }}"><i class="fa fa-shopping-bag"></i>Product</a></li>
          </ul>


          <span class="heading">Author</span>
          <ul class="list-unstyled">
            <li> 
              <a href="{{ route('admin_author') }}">
                <i class="fa fa-users "></i>Author
              </a>
            </li>
            <li> 
              <a href="{{ route('admin_author_add') }}">
                <i class="fa fa-user-plus "></i>Add Author
              </a>
          </ul>
          

          <span class="heading">Administrator</span>
          <ul class="list-unstyled">
            <li> 
              <a href="{{ route('admin_admin') }}">
                <i class="fa fa-user-circle-o"></i>Admin
              </a>
            </li>
            <li> 
              <a href="{{ route('admin_add_admin') }}">
                <i class="fa fa-plus-circle"></i>Add Admin
              </a>
          </ul>


          <span class="heading">Category</span>
          <ul class="list-unstyled">
            <li> 
              <a href="{{ route('admin_list_category') }}">
                <i class="fa fa fa-tags"></i>Category
              </a>
            </li>
            <li> 
              <a href="{{ route('admin_add_category') }}">
                <i class="fa fa-plus-circle"></i>Add Category
              </a>
          </ul>

          <span class="heading">Blog</span>
          <ul class="list-unstyled">
            <li> <a href="#"><i class="fa fa-sticky-note"></i>Post</a></li>
            <li> <a href="#"><i class="fa fa-pencil-square-o"></i>Add Post</a></li>
          </ul>
         
        </nav>