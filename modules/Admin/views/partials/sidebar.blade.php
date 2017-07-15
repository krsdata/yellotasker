        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
         
 <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                   
                    <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        <li class="nav-item start active open">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                                <span class="selected"></span>
                                <span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item start active open">
                                    <a href="{{ url('/')}}" class="nav-link ">
                                        <i class="icon-bar-chart"></i>
                                        <span class="title">Dashboard</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                        
                        <li class="heading">
                            <h3 class="uppercase">Manage </h3>
                        </li>
                        

                        <li class="nav-item  {{ (isset($page_title) && $page_title=='User')?'open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-user"></i>
                                <span class="title">User</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='User')?'block':'' }}">
                                <li class="nav-item  {{ (isset($page_title) && $page_action=='Create User')?'active':'' }}">
                                    <a href="{{ route('user.create') }}" class="nav-link ">
                                        <i class="icon-user"></i>
                                        <span class="title">
                                            Create User
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item  {{ (isset($page_title) && $page_action=='View User')?'active':'' }}">
                                    <a href="{{ route('user') }}" class="nav-link ">
                                        <i class="icon-user"></i>
                                        <span class="title">
                                            Users
                                        </span>
                                    </a>
                                </li>
                              
                             
                            </ul>
                        </li> 



                         <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-settings"></i>
                                <span class="title">Roles</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                
                                <li class="nav-item  ">
                                    <a href="#" class="nav-link "  >
                                        <span class="title">Coming Soon</span>
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                       
                         <li class="nav-item  {{ (isset($page_title) && $page_title=='Category')?'open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-folder-open-o"></i>
                                <span class="title">Category Management</span>
                                <span class="arrow {{ (isset($page_title) && $page_title=='Category')?'open':'' }}"></span>
                            </a>
                            <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Category')?'block':'' }}">
                                
                                <li class="nav-item  {{ (isset($sub_page_title) && $sub_page_title=='Group Category')?'open':'' }}">

                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="fa fa-folder-o"></i>
                                        <span class="title">Group Category</span>
                                        <span class="arrow {{ (isset($page_title) && $page_title=='Category')?'open':'' }}"></span>
                                    </a>
                                    <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Category')?'block':'' }}">
                                        <li class="nav-item {{ (isset($page_action) && $page_action=='Create Group Category')?'open':'' }}">
                                            <a href="{{ route('category.create') }}" class="nav-link "  > Create Group category</a>
                                        </li>
                                        <li class="nav-item {{ (isset($page_action) && $page_action=='View Group Category')?'open':'' }}">
                                            <a href="{{ route('category') }}" class="nav-link " >View Group Category</a>
                                        </li>
                                        
                                    </ul>
                                </li>
                                 <li class="nav-item  {{ (isset($sub_page_title) && $sub_page_title=='Sub Category')?'open':'' }}">

                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="fa fa-folder-o"></i>
                                        <span class="title">Category</span>
                                        <span class="arrow {{ (isset($sub_page_title) && $sub_page_title=='Sub Category')?'open':'' }}"></span>
                                    </a>
                                    <ul class="sub-menu"  style="display: {{ (isset($sub_page_title) && $sub_page_title=='Sub Category')?'block':'' }}">
                                        <li class="nav-item {{ (isset($page_action) && $page_action=='Create Sub Category')?'open':'' }}">
                                            <a href="{{ route('sub-category.create') }}" class="nav-link " > Create Category</a>
                                        </li>
                                        <li class="nav-item {{ (isset($page_action) && $page_action=='View Sub Category')?'open':'' }}">
                                            <a href="{{ route('sub-category') }}" class="nav-link "  >View Category</a>
                                        </li>
                                        
                                    </ul>
                                </li>
                                
                            </ul>
                        </li>
                        
                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>