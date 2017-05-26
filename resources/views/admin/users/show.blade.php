      @extends('admin.layout.master')                


      @section('main_content')
      <!-- BEGIN Page Title -->
      <div class="page-title">
          <div>

          </div>
      </div>
      <!-- END Page Title -->

      <!-- BEGIN Breadcrumb -->
      <div id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ url($admin_panel_slug.'/dashboard') }}">Dashboard</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li>
                <i class="fa fa-desktop"></i>
                <a href="{{ $module_url_path }}">{{ $module_title or ''}}</a>
            </li>   
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active"> {{ isset($page_title)?$page_title:"" }}</li>
        </ul>
      </div>
      <!-- END Breadcrumb -->

 
        <!-- START Main Content -->


          <div class="row">
            <div class="col-md-12">
                <div class="box {{ $theme_color }}">
                    <div class="box-title">
                        <h3><i class="fa fa-file"></i> City Information</h3>
                        <div class="box-tool">
                          
                        </div>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-md-9 user-profile-info">
                                <p><span>City Name:</span>{{ isset($arr_data['city_title'])?$arr_data['city_title']:'' }}</p>

                                 <p><span>State Name:</span> {{ isset($arr_data['state_details']['state_title'])?$arr_data['state_details']['state_title']:'-' }}</p>
                               
                                <p><span>Country Name:</span> {{ isset($arr_data['country_details']['country_name'])?$arr_data['country_details']['country_name']:'' }}</p>                                        
                                 
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- END Main Content -->


  @stop                    


