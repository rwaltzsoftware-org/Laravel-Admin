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
      <i class="fa fa-home">
      </i>
      <a href="{{ url($admin_panel_slug.'/dashboard') }}">Dashboard
      </a>
    </li>
     <span class="divider">
      <i class="fa fa-angle-right">
      </i>
      <i class="fa {{$module_icon}}">
      </i>
    </span> 
    <li >  <a href="{{$module_url_path}}">{{ isset($module_title)?$module_title:"" }}</a>
    </li>
    <span class="divider">
      <i class="fa fa-angle-right">
      </i>
      <i class="fa {{$edit_icon}}">
      </i>
    </span> 
    <li class="active">  {{ isset($page_title)?$page_title:"" }}
    </li>
  </ul>
</div>
<!-- END Breadcrumb -->

<!-- BEGIN Main Content -->
<div class="row">
  <div class="col-md-12">
    <div class="box {{ $theme_color }}">
      <div class="box-title">
        <h3>
          <i class="fa {{$edit_icon}}">
          </i>{{ isset($page_title)?$page_title:"" }} 
        </h3>
        <div class="box-tool">
        </div>
      </div>
      <div class="box-content studt-padding">
        
        @include('admin.layout._operation_status')
   
         
          <form method="POST" id="validation-form" class="form-horizontal" action="{{$module_url_path}}/update" enctype="multipart/form-data">
                
                {{ csrf_field() }} 
                                  
                  @if(isset($arr_data) && sizeof($arr_data)>0)
                  
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label" >Keyword </label>
                        <div class="col-sm-6 col-lg-6 controls"><input name="keyword" readonly="" value="{{isset($keyword) ? $keyword : ''}}" class="form-control"/></div>
                    </div>

                    @foreach($arr_data as $key => $data)                 
                        
                        <input type="hidden" name="keyword_arr[{{$key}}][id]" value="{{isset($data['id']) ? $data['id'] : ''}}"> 

                          <div class="form-group">
                              <label class="col-sm-3 col-lg-2 control-label" >Title ({{isset($data['locale']) ? $data['locale'] : ''}})  <i class="red">*</i></label>

                              <div class="col-sm-6 col-lg-6 controls">
                              <input type="text" name="keyword_arr[{{$key}}][title]" data-rule-required="true" placeholder="Enter Module Title" value="{{isset($data['title']) ? $data['title'] : ''}}" class="form-control"/>
                              </div>
                              <span class='help-block'>{{ $errors->first($data['title']) }}</span>  
                          </div>
                    
                      @endforeach
                    
                    @endif                

                    <div class="form-group">
                          <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                            <input type="submit" class="btn btn btn-primary" value="Update"/>
                          </div>
                    </div>                
            </form>            

        </div>
      </div>
  </div>
  <!-- END Main Content --> 

  

  <script type="text/javascript">
  
  $(document).ready(function()
  {
     
    $("#autocomplete").bind('keypress',function(event)
    {
    });

  }); 

  </script>

  @endsection
