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
      <a href="{{ url($admin_panel_slug.'/dashboard') }}"> Dashboard </a>
    </li>
    <span class="divider">
      <i class="fa fa-angle-right"></i>
      <i class="fa fa-envelope"></i>
      <a href="{{ $module_url_path }}"> {{ $module_title or ''}} </a>
    </span> 
    <span class="divider">
      <i class="fa fa-angle-right"></i>
      <i class="fa fa-plus-square-o"></i>
    </span>
    <li class="active"> {{ $page_title or ''}} </li>
  </ul>
</div>
<!-- END Breadcrumb -->
<!-- BEGIN Main Content -->
<div class="row">
  <div class="col-md-12">
    <div class="box {{ $theme_color }}">
      <div class="box-title">
        <h3>
          <i class="fa fa-plus-square-o"></i>
          {{ isset($page_title)?$page_title:"" }}
        </h3>
        <div class="box-tool">
          <a data-action="collapse" href="#"></a>
          <a data-action="close" href="#"></a>
        </div>
      </div>
      <div class="box-content">
        @include('admin.layout._operation_status')
          {!! Form::open([ 'url' => $module_url_path.'/store',
          'method'=>'POST',
          'enctype' =>'multipart/form-data',   
          'class'=>'form-horizontal', 
          'id'=>'validation-form' 
          ]) !!} 
          {{ csrf_field() }}
          <div  class="tab-content">                 
              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="email"> Email Template Name 
                  <i class="red">*</i> 
                </label>
                <div class="col-sm-6 col-lg-4 controls">       
                  {!! Form::text('template_name',old('template_name'),['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'255', 'placeholder'=>'Email Template Name']) !!}  
                </div>
                <span class='help-block'> {{ $errors->first('template_name') }} </span>  
              </div>
              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="email"> Email Template Subject 
                  <i class="red">*</i> 
                </label>
                <div class="col-sm-6 col-lg-4 controls">       
                  {!! Form::text('template_subject',old('template_subject'),['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'255', 'placeholder'=>'Email Template Subject']) !!}  
                </div>
                <span class='help-block'> {{ $errors->first('template_subject') }} </span>  
              </div>

              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="email"> Email Template Body 
                  <i class="red">*</i> 
                </label>
                <div class="col-sm-6 col-lg-7 controls">   
                  {!! Form::textarea('template_html',old('template_html'),['class'=>'form-control', 'class'=>'form-control wysihtml5', 'rows'=>'10', 'data-rule-required'=>'true', 'placeholder'=>'Email Template Body']) !!}  
                </div>
                <span class='help-block'> {{ $errors->first('template_html') }} </span>  
              </div>


              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="email"> Variables 
                  <i class="red">*</i> 
                </label>
                <div class="col-sm-6 col-lg-7 controls">   
                  {!! Form::text('variables[]',old('variables[]'),['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'500', 'placeholder'=>'Variables']) !!}  
                </div>
                <a class="btn btn-primary" href="javascript:void(0)" onclick="add_text_field()">
                  <i class="fa fa-plus"></i>
                </a>
                <a class="btn btn-danger" href="javascript:void(0)" onclick="remove_text_field(this)">
                  <i class="fa fa-minus"></i>
                </a>
                <span class='help-block'> {{ $errors->first('variables[]') }} </span>  
              </div>
              <div id="append_variables"></div>
              <br>
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                {!! Form::submit('Save',['class'=>'btn btn btn-primary','value'=>'true'])!!}
              </div>
            </div>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
  <!-- END Main Content -->

  <script type="text/javascript">
   function add_text_field() 
   {
       var html = "<div class='form-group appended' id='appended'><label class='col-sm-3 col-lg-2 control-label'></label><div class='col-sm-6 col-lg-4 controls'><input class='form-control' name='variables[]' data-rule-required='true' placeholder='Variables' /></div><div id='append_variables'></div></div>";
       jQuery("#append_variables").append(html);
   }

   function remove_text_field(elem)
   {
      $( ".appended:last" ).remove();
   }

  $(document).ready(function()
  {
    tinymce.init({
      selector: 'textarea',
      relative_urls: false,
      remove_script_host:false,
      convert_urls:false,
      plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code'
      ],
      toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
      content_css: [
        '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
        '//www.tinymce.com/css/codepen.min.css'
      ]
    });
  });
 </script>
@stop