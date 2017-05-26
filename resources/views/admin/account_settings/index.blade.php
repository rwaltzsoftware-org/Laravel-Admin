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
          <i class="fa {{$module_icon}}">
          </i>{{ isset($page_title)?$page_title:"" }} 
        </h3>
        <div class="box-tool">
        </div>
      </div>
      <div class="box-content">
        @include('admin.layout._operation_status')
        {!! Form::open([ 'url' => $module_url_path.'/update/'.base64_encode($arr_data['id']),
        'method'=>'POST',   
        'class'=>'form-horizontal', 
        'id'=>'validation-form' 
        ]) !!}
        <div class="form-group">
          <label class="col-sm-3 col-lg-2 control-label">First Name
            <i class="red">*
            </i>
          </label>
          <div class="col-sm-9 col-lg-4 controls">
            {!! Form::text('first_name',$arr_data['first_name'],['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'255', 'placeholder'=>'First Name']) !!}
            <span class='help-block'>{{ $errors->first('first_name') }}
            </span>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 col-lg-2 control-label">Last Name
            <i class="red">*
            </i>
          </label>
          <div class="col-sm-9 col-lg-4 controls">
            {!! Form::text('last_name',$arr_data['last_name'],['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'255', 'placeholder'=>'Last Name']) !!}
            <span class='help-block'>{{ $errors->first('last_name') }}
            </span>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 col-lg-2 control-label">Email
            <i class="red">*
            </i>
          </label>
          <div class="col-sm-9 col-lg-4 controls">
            {!! Form::text('email',$arr_data['email'],['class'=>'form-control', 'data-rule-required'=>'true', 'data-rule-email'=>'true', 'data-rule-maxlength'=>'255', 'placeholder'=>'Email']) !!}
            <span class='help-block'>{{ $errors->first('email') }}
            </span>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 col-lg-2 control-label">Old Password
          </label>
          <div class="col-sm-9 col-lg-4 controls">
            {!! Form::password('old_password',['class'=>'form-control','data-rule-maxlength'=>'255', 'placeholder'=>'Old Password']) !!}
            <span class='help-block'>{{ $errors->first('old_password') }}
            </span>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 col-lg-2 control-label">New Password
          </label>
          <div class="col-sm-9 col-lg-4 controls">
            {!! Form::password('new_password',['class'=>'form-control','data-rule-maxlength'=>'255','id'=>'new_password', 'placeholder'=>'New Password']) !!}
            <span class='help-block'>{{ $errors->first('new_password') }}
            </span>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 col-lg-2 control-label">Confirm Password
          </label>
          <div class="col-sm-9 col-lg-4 controls">
            {!! Form::password('new_password_confirmation',['class'=>'form-control','data-rule-maxlength'=>'255','data-rule-equalto'=>'#new_password', 'placeholder'=>'Confirm Password']) !!}
            <span class='help-block'>{{ $errors->first('confirm_password') }}
            </span>
          </div>
        </div>     
        <div class="form-group">
          <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
            {!! Form::submit('Update',['class'=>'btn btn btn-primary','value'=>'true'])!!}
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!-- END Main Content --> 
  @endsection
