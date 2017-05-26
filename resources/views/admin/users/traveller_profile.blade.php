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
                <i class="fa fa-users"></i>
                <a href="{{ $module_url_path }}">{{ $module_title or ''}}</a>
            </li>   
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active"><i class="fa fa-user"></i> {{ $page_title or ''}}</li>
        </ul>
    </div>
    <!-- END Breadcrumb -->



    <!-- BEGIN Main Content -->
    <div class="row">
      <div class="col-md-12">
          <div class="box {{ $theme_color }}">
            <div class="box-title">
              <h3>
                <i class="fa fa-user"></i>
                {{ isset($page_title)?$page_title:"" }}
              </h3>
              <div class="box-tool">
                <a data-action="collapse" href="#"></a>
                <a data-action="close" href="#"></a>
              </div>
            </div>
            <div class="box-content">

          @include('admin.layout._operation_status')  
          
           {!! Form::open([ 'url' => $module_url_path.'/traveller_store',
                                 'method'=>'POST',
                                 'enctype' =>'multipart/form-data',   
                                 'class'=>'form-horizontal', 
                                 'id'=>'validation-form' 
                                ]) !!} 

           {{ csrf_field() }}

            {!! Form::hidden('user_id',isset($arr_traveller['user_id']) ? $arr_traveller['user_id']: "",[]) !!}

            <div class="form-group" style="margin-top: 25px;">
                  <label class="col-sm-3 col-lg-2 control-label">About Me</label>
                  <div class="col-sm-9 col-lg-4 controls" >

                       {!! Form::text('about_me',isset($arr_traveller['about_me']) ? $arr_traveller['about_me']: "",['class'=>'form-control','data-rule-required'=>'', 'placeholder'=>'Enter About Me']) !!}

                      <span class="help-block">{{ $errors->first('about_me') }}</span>
                  </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">Current City</label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      
                      {!! Form::text('current_city',isset($arr_traveller['current_city']) ? $arr_traveller['current_city']: "",['class'=>'form-control','data-rule-required'=>'', 'placeholder'=>'Enter Current City']) !!}
                      
                      <span class="help-block">{{ $errors->first('current_city') }}</span>
                  </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">Languages</label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      
                      {!! Form::text('languages',isset($arr_traveller['languages']) ? $arr_traveller['languages']: "",['class'=>'form-control','data-rule-required'=>'', 'placeholder'=>'Enter Languages']) !!}
                      
                      <i style="color:black;font-size:10px;">* Please enter comma seperated languages ex. English,Spanish</i>
                      <span class="help-block">{{ $errors->first('email') }}</span>
                  </div>
            </div>

            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
               
                {!! Form::submit('Update',['class'=>'btn btn btn-primary','value'=>'true'])!!}
                &nbsp;
                <a class="btn btn-primary" href="{{ $module_url_path }}">Back</a>
              </div>
            </div>
    
          {!! Form::close() !!}
      </div>
    </div>
  </div>
  
  <!-- END Main Content -->


@stop                    
