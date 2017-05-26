
<?php
        $admin_path     = config('app.project.admin_panel_slug');
?>

<div id="sidebar" class="navbar-collapse collapse">
                <!-- BEGIN Navlist -->
                <ul class="nav nav-list">
                    
                    
                    <li class="<?php  if(Request::segment(2) == 'dashboard'){ echo 'active'; } ?>">
                        <a href="{{ url('/').'/'.$admin_path.'/dashboard'}}">
                            <i class="fa fa-dashboard faa-vertical animated-hover"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="<?php  if(Request::segment(2) == 'account_settings'){ echo 'active'; } ?>">
                        <a href="{{ url('/').'/'.$admin_path.'/account_settings' }}" >
                            <i class="fa fa-cogs faa-vertical animated-hover"></i>


                            <span>Account Settings</span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                    </li> 

                    <li class="<?php  if(Request::segment(2) == 'activity_logs'){ echo 'active'; } ?>">
                        <a href="{{ url('/').'/'.$admin_path.'/activity_logs' }}" >
                            <i class="fa fa-history" aria-hidden="true"></i>
                            <span>Activity Log</span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                    </li>

                    <li class="<?php  if(Request::segment(2) == 'admin_users'){ echo 'active'; } ?>">
                        <a href="javascript:void(0)" class="dropdown-toggle" >
                            <i class="fa fa-user-secret faa-vertical animated-hover"></i>


                            <span>Admin Users</span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                        <ul class="submenu">
                            <li style="display: block;"><a href="{{ url($admin_panel_slug.'/admin_users')}}">Manage </a></li>             
                        </ul>

                    </li>

                    <li class="<?php  if(Request::segment(2) == 'contact_enquiry'){ echo 'active'; } ?>">
                        <a href="javascript:void(0)" class="dropdown-toggle" >
                            <i class="fa fa-info-circle faa-vertical animated-hover"></i>
                                <span>Contact Enquirys</span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                        <ul class="submenu">
                            <li style="display: block;"><a href="{{ url($admin_panel_slug.'/contact_enquiry')}}">Manage </a></li>                            
                        </ul>

                    </li>

                    <li class="<?php  if(Request::segment(2) == 'static_pages'){ echo 'active'; } ?>">
                        <a href="javascript:void(0)" class="dropdown-toggle">
                            <i class="fa  fa-sitemap faa-vertical animated-hover"></i>
                            <span>CMS</span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                         <ul class="submenu">
                            <li style="display: block;"><a href="{{ url($admin_panel_slug.'/static_pages')}}">Manage </a></li>                            
                        </ul>
                  </li>

                  

                    <li class="<?php  if(Request::segment(2) == 'email_template'){ echo 'active'; } ?>">
                        <a href="javascript:void(0)" class="dropdown-toggle">
                            <i class="fa fa-envelope faa-vertical animated-hover"></i>
                            <span>Email Templates</span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                         <ul class="submenu">
                            <li style="display: block;"><a href="{{ url($admin_panel_slug.'/email_template')}}">Manage</a> </li>
                        </ul>
                    </li>


                    <li class="<?php  if(Request::segment(2) == 'faq'){ echo 'active'; } ?>">
                        <a href="javascript:void(0)" class="dropdown-toggle">
                            <i class="fa fa-question-circle faa-vertical animated-hover"></i>
                            <span>FAQ</span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                         <ul class="submenu">
                            <li style="display: block;"><a href="{{ url($admin_panel_slug.'/faq')}}">Manage </a></li>                            
                        </ul>
                  </li>

                    <li class="<?php  if(Request::segment(2) == 'site_settings'){ echo 'active'; } ?>">
                        <a href="{{ url($admin_panel_slug.'/site_settings') }}" >
                            <i class="fa  fa-wrench faa-vertical animated-hover"></i>
                            <span>Site Settings</span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                    </li>


                    <li class="<?php  if(Request::segment(2) == 'users'){ echo 'active'; } ?>">
                        <a href="javascript:void(0)" class="dropdown-toggle">
                            <i class="fa fa-users faa-vertical animated-hover" aria-hidden="true"></i>
                            <span>Users</span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>
                            <ul class="submenu">
                            <li style="display: block;"><a href="{{ url($admin_panel_slug.'/users')}}">Manage </a></li>
                        </ul>
                    </li>


                     <!--  <li class="<?php  if(Request::segment(2) == 'language'){ echo 'active'; } ?>">
                        <a href="javascript:void(0)" class="dropdown-toggle">
                            <i class="fa fa-puzzle-piece"></i>
                            <span>Language</span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                         <ul class="submenu">
                            <li style="display: block;"><a href="{{ url('/admin/language')}}">Manage </a></li> 
                        </ul>
                    </li> -->

                
                   <li class="<?php  if(Request::segment(2) == 'categories'){ echo 'active'; } ?>">
                        <a href="javascript:void(0)" class="dropdown-toggle">
                            <i class="fa fa-list-alt  faa-vertical animated-hover"></i>
                            <span>Categories</span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                         <ul class="submenu">
                            <li style="display: block;"><a href="{{ url('/').'/'.$admin_path.'/categories'}}">Manage </a></li>                            
                        </ul>
                    </li>

                    <li class="<?php  if(Request::segment(2) == 'countries' || Request::segment(2) == 'states' || Request::segment(2) == 'cities' || Request::segment(2) == 'countries' ){ echo 'active'; } ?>"> 
                        <a href="javascript:void(0)" class="dropdown-toggle">
                            <i class="fa fa-globe faa-vertical animated-hover"></i>
                            <span>Locations</span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                         <ul class="submenu">

                            
                            <li class="<?php  if(Request::segment(2) == 'states'){ echo 'active'; } ?>"><a href="{{ url('/').'/'.$admin_path.'/states'}}">Manage State/Regions</a></li>

                            <li class="<?php  if(Request::segment(2) == 'cities'){ echo 'active'; } ?>"><a href="{{ url('/').'/'.$admin_path.'/cities'}}">Manage Cities</a></li> 
                            <li class="<?php  if(Request::segment(2) == 'countries'){ echo 'active'; } ?>"><a href="{{ url('/').'/'.$admin_path.'/countries'}}">Manage Country</a></li> 
                        </ul>
                    </li>
                    
                    <li class="<?php  if(Request::segment(2) == 'activity_logs'){ echo 'active'; } ?>" title="Keyword Translations">
                        <a href="{{ url('/').'/'.$admin_path.'/keyword_translation' }}" >
                            <i class="fa fa-language" aria-hidden="true"></i>
                            <span>{{str_limit('Keyword Translations',18)}}</span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                    </li>
               
                <!-- END Navlist -->

                <!-- BEGIN Sidebar Collapse Button -->
                <div id="sidebar-collapse" class="visible-lg">
                    <i class="fa fa-angle-double-left"></i>
                </div>
                <!-- END Sidebar Collapse Button -->
            </div>

   