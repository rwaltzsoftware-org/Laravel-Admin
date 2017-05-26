<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{{ isset($page_title)?$page_title:"" }} - {{ config('app.project.name') }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <!--base css styles-->
        <link rel="stylesheet" href="{{ url('/') }}/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ url('/') }}/assets/font-awesome/css/font-awesome.min.css">

        <!--page specific css styles-->
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/bootstrap-fileupload/bootstrap-fileupload.css" />

        <!--flaty css styles-->
        <link rel="stylesheet" href="{{ url('/') }}/css/admin/flaty.css">
        <link rel="stylesheet" href="{{ url('/') }}/css/admin/flaty-responsive.css">

        <link rel="stylesheet" href="{{ url('/') }}/assets/jquery-ui/jquery-ui.min.css">
       

        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/bootstrap-switch/static/stylesheets/bootstrap-switch.css" />
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />

        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/css/admin/select2.min.css" />
       
       <!-- Auto load email address -->
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/chosen-bootstrap/chosen.min.css" />

        <!--basic scripts-->

    
        <script>window.jQuery || document.write('<script src="{{ url('/') }}/assets/jquery/jquery-2.1.4.min.js"><\/script>')</script>

 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        


        <script src="{{ url('/') }}/assets/jquery-ui/jquery-ui.min.js"></script>
        <script src="{{ url('/') }}/js/admin/select2.min.js"></script>

        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/jquery-tags-input/jquery.tagsinput.css" />
    
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/bootstrap-duallistbox/duallistbox/bootstrap-duallistbox.css" />
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/dropzone/downloads/css/dropzone.css" />
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/bootstrap-colorpicker/css/colorpicker.css" />

        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/chosen-bootstrap/chosen.min.css" />
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/font-awesome/css/font-awesome-animation.min.css" />
      
 
        
    </head>
    <body class="{{ theme_body_color() }}">
    <?php
            $admin_path = config('app.project.admin_panel_slug');
    ?>
        <!-- BEGIN Theme Setting -->
        <div id="theme-setting">
            <a href="#"><i class="fa fa-gears fa fa-2x"></i></a>
            <ul>
                <li>
                    <span>Skin</span>
                    <ul class="colors" data-target="body" data-prefix="skin-">
                        <li class="active"><a class="blue" href="#"></a></li>
                        <li><a class="red" href="#"></a></li>
                        <li><a class="green" href="#"></a></li>
                        <li><a class="orange" href="#"></a></li>
                        <li><a class="yellow" href="#"></a></li>
                        <li><a class="pink" href="#"></a></li>
                        <li><a class="navi_blue" href="#"></a></li>
                        {{-- <li><a class="magenta" href="#"></a></li> --}}
                        <li><a class="gray" href="#"></a></li>
                        <li><a class="black" href="#"></a></li>
                    </ul>
                </li>
                <li>
                    <span>Navbar</span>
                    <ul class="colors" data-target="#navbar" data-prefix="navbar-">
                        <li class="active"><a class="blue" href="#"></a></li>
                        <li><a class="red" href="#"></a></li>
                        <li><a class="green" href="#"></a></li>
                        <li><a class="orange" href="#"></a></li>
                        <li><a class="yellow" href="#"></a></li>
                        <li><a class="pink" href="#"></a></li>
                        <li><a class="navi_blue" href="#"></a></li>
                        {{-- <li><a class="magenta" href="#"></a></li> --}}
                        <li><a class="gray" href="#"></a></li>
                        <li><a class="black" href="#"></a></li>
                    </ul>
                </li>
                <li>
                    <span>Sidebar</span>
                    <ul class="colors" data-target="#main-container" data-prefix="sidebar-">
                        <li class="active"><a class="blue" href="#"></a></li>
                        <li><a class="red" href="#"></a></li>
                        <li><a class="green" href="#"></a></li>
                        <li><a class="orange" href="#"></a></li>
                        <li><a class="yellow" href="#"></a></li>
                        <li><a class="pink" href="#"></a></li>
                        <li><a class="navi_blue" href="#"></a></li>
                        {{-- <li><a class="magenta" href="#"></a></li> --}}
                        <li><a class="gray" href="#"></a></li>
                        <li><a class="black" href="#"></a></li>
                    </ul>
                </li>
                <li>
                    <span></span>
                    <a data-target="navbar" href="#"><i class="fa fa-square-o"></i> Fixed Navbar</a>
                    <a class="hidden-inline-xs" data-target="sidebar" href="#"><i class="fa fa-square-o"></i> Fixed Sidebar</a>
                </li>
            </ul>
        </div>
        <!-- END Theme Setting -->

        <!-- BEGIN Navbar -->
        <div id="navbar" class="navbar {{ theme_navbar_color() }}">
            <button type="button" class="navbar-toggle navbar-btn collapsed" data-toggle="collapse" data-target="#sidebar">
                <span class="fa fa-bars"></span>
            </button>
            <a class="navbar-brand" href="#">
                <small>
                    <i class="fa fa-desktop"></i>
                    {{ config('app.project.name') }} Admin
                </small>
            </a>

            <!-- BEGIN Navbar Buttons -->
            <ul class="nav flaty-nav pull-right">
                <!-- BEGIN Button Tasks -->
                {{-- <li class="hidden-xs">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="fa fa-tasks"></i>
                        <span class="badge badge-warning">4</span>
                    </a>

                    <!-- BEGIN Tasks Dropdown -->
                    <ul class="dropdown-navbar dropdown-menu">
                        <li class="nav-header">
                            <i class="fa fa-check"></i>
                            4 Tasks to complete
                        </li>

                        <li>
                            <a href="#">
                                <div class="clearfix">
                                    <span class="pull-left">Software Update</span>
                                    <span class="pull-right">75%</span>
                                </div>

                                <div class="progress progress-mini">
                                    <div style="width:75%" class="progress-bar progress-bar-warning"></div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <div class="clearfix">
                                    <span class="pull-left">Transfer To New Server</span>
                                    <span class="pull-right">45%</span>
                                </div>

                                <div class="progress progress-mini">
                                    <div style="width:45%" class="progress-bar progress-bar-danger"></div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <div class="clearfix">
                                    <span class="pull-left">Bug Fixes</span>
                                    <span class="pull-right">20%</span>
                                </div>

                                <div class="progress progress-mini">
                                    <div style="width:20%" class="progress-bar"></div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <div class="clearfix">
                                    <span class="pull-left">Writing Documentation</span>
                                    <span class="pull-right">85%</span>
                                </div>

                                <div class="progress progress-mini progress-striped active">
                                    <div style="width:85%" class="progress-bar progress-bar-success"></div>
                                </div>
                            </a>
                        </li>

                        <li class="more">
                            <a href="#">See tasks with details</a>
                        </li>
                    </ul>
                    <!-- END Tasks Dropdown -->
                </li> --}}
                <!-- END Button Tasks -->

                <!-- BEGIN Button Notifications -->
               <?php
                $obj_data  = Sentinel::getUser();
        
                if($obj_data)
                {
                   $arr_data = $obj_data->toArray();    
                }
               ?>

               
                <!-- END Button Messages -->

                <!-- BEGIN Button User -->
                <li class="user-profile">
                    <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
                        
                        <span class="hhh" id="user_info">
                          Welcome {{$arr_data['first_name'] or ''}}
                        </span>
                        <i class="fa fa-caret-down"></i>
                    </a>

                    <!-- BEGIN User Dropdown -->
                    <ul class="dropdown-menu dropdown-navbar" id="user_menu">
                        <li>
                            <a href="{{ url('/').'/'.$admin_path }}/change_password" >
                                <i class="fa fa-key"></i>
                                Change Password
                            </a>    
                        </li>    
                        <li class="divider"></li>

                        <li>
                             <a href="{{ url('/').'/'.$admin_path }}/logout "> 
                                <i class="fa fa-power-off"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                    <!-- BEGIN User Dropdown -->
                </li>
                <!-- END Button User -->
            </ul>
            <!-- END Navbar Buttons -->
        </div>
        <!-- END Navbar -->
        
        <!-- BEGIN Container -->
        <div class="container {{ theme_sidebar_color() }}" id="main-container">