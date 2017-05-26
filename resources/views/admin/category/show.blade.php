      @extends('web_admin.template.admin')                


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
                <a href="{{ url('/').'/web_admin/dashboard' }}">Dashboard</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li>
                <i class="fa fa-list-alt"></i>
                <a href="{{ url('/').'/web_admin/cities' }}">City</a>
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
                <div class="box ">
                    <div class="box-title">
                        <h3><i class="fa fa-file"></i> City Information</h3>
                        <div class="box-tool">
                          
                        </div>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-md-2">  
                                @if(isset($arr_cities[0]['city_image']))
                                     <img class="img-responsive img-thumbnail"  src="{{ url('/')}}/uploads/cities/{{$arr_cities[0]['city_image']}}" alt="State logo" /> 
                                @endif
                                <br/>
                            </div>
                            <div class="col-md-9 user-profile-info">
                                <p><span>City Name:</span>{{ isset($arr_cities[0]['city_title'])?$arr_cities[0]['city_title']:'' }}</p>

                                 <p><span>State Name:</span> {{ isset($arr_cities[0]['state_details']['state_title'])?$arr_cities[0]['state_details']['state_title']:'-' }}</p>
                               
                                <p><span>Country Name:</span> {{ isset($arr_cities[0]['country_details']['country_name'])?$arr_cities[0]['country_details']['country_name']:'' }}</p>                                        
                                 
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
  



        <!-- END Main Content -->


  @stop                    


