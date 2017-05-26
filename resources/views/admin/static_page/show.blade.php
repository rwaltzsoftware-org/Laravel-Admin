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
                <i class="fa fa-desktop"></i>
                <a href="{{ url('/').'/web_admin/static_pages' }}">Static Pages</a>
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
                                <h3><i class="fa fa-file"></i> Static Page Information</h3>
                                <div class="box-tool">
                                  
                                </div>
                            </div>
                            <div class="box-content">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img class="img-responsive img-thumbnail" src="{{ isset($arr_pages['image_url'])? url('/') .'/uploads/static_pages/'.$arr_pages['image_url']:'' }}" alt="Page logo" />
                                        <br/><br/>
                                    </div>
                                    <div class="col-md-9 user-profile-info">
                                        <p><span>Page Name:</span>{{ isset($arr_pages['page_name'])?$arr_pages['page_name']:'' }}</p>  
                                        <p><span>Page Title:</span> {{ isset($page_title)?$arr_pages['page_title']:'' }}</p>
                                        <p><span>Page Description:</span>  
                                             
                                                 {!! isset($arr_pages['page_desc'])?$arr_pages['page_desc']:'' !!}
                                             
                                        </p>                              
                                        <p><span>Meta keyword:</span> {{ isset($arr_pages['meta_keyword'])?$arr_pages['meta_keyword']:'' }}</p> 
                                        <p><span>Meta Description:</span> {{ isset($arr_pages['meta_desc'])?$arr_pages['meta_desc']:'' }}</p> 
                                        <p><span>Page slug:</span> {{ isset($arr_pages['page_slug'])?$arr_pages['page_slug']:'' }}</p>    
                                                              
                                        <p><span>Status:</span> {{ ($arr_pages['is_active'])?'Active':'Deactive' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              



        <!-- END Main Content -->


  @stop                    


