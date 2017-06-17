<header class="main-header">
        <!-- sign  -->
        <a class="logo" href="{{ url('admin') }}">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>API</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Admin Panel</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav role="navigation" class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a role="button" data-toggle="offcanvas" class="sidebar-toggle" href="#">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less--> 
             
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                  <img alt="User Image" class="user-image" src="{{ URL::asset('public/assets/dist/img/user2-160x160.jpg') }} ">
                  <span class="hidden-xs">Welcome Admin</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img alt="User Image" class="img-circle" src="{{ URL::asset('public/assets/dist/img/user2-160x160.jpg') }}">
                    <p>
                     Admin
                      
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a class="btn btn-default btn-flat" href="{{ url('admin/profile')}}">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a class="btn btn-default btn-flat" href="{{ url('logout')}}">Sign out</a>
                    </div>
                  </li>

                  
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              
            </ul>
          </div>
        </nav>
      </header>