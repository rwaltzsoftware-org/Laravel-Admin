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
                <i class="fa fa-wrench"></i>
            </span> 
            <li class="active">  {{ isset($page_title)?$page_title:"" }}</li>
        </ul>
    </div>
    <!-- END Breadcrumb -->

    <!-- BEGIN Main Content -->
    
    
    <div class="row">
        <div class="col-md-12">
            <div class="box  {{ $theme_color }}">
                <div class="box-title">
                    <h3><i class="fa fa-wrench"></i> {{ isset($page_title)?$page_title:"" }}</h3>
                    <div class="box-tool">
                    </div>
                </div>
                <div class="box-content">
                    @include('admin.layout._operation_status')
                    
                    {!! Form::open([ 'url' => $module_url_path.'/update/'.base64_encode($arr_data['site_setting_id']),
                                 'method'=>'POST',   
                                 'class'=>'form-horizontal', 
                                 'id'=>'validation-form' 
                                ]) !!}

                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Website Name<i class="red">*</i></label>
                            <div class="col-sm-9 col-lg-4 controls">
                                {!! Form::text('site_name',isset($arr_data['site_name'])?$arr_data['site_name']:'',['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'255']) !!}
                                <span class='help-block'>{{ $errors->first('site_name') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label" for="category_name">Address<i class="red">*</i></label>
                            <div class="col-sm-10 col-lg-4 controls">
                                {!! Form::text('site_address',isset($arr_data['site_address'])?$arr_data['site_address']:'',['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'255']) !!}
                                <span class='help-block'>{{ $errors->first('site_address') }}</span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Contact Number<i class="red">*</i></label>
                            <div class="col-sm-9 col-lg-4 controls">
                                {!! Form::text('site_contact_number',isset($arr_data['site_contact_number'])?$arr_data['site_contact_number']:'',['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'255', 'data-rule-digits'=>'true']) !!}
                                <span class='help-block'>{{ $errors->first('site_contact_number') }}</span>
                            </div>
                        </div>

                         <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label" for="category_name">Meta Description<i class="red"></i></label>
                            <div class="col-sm-9 col-lg-4 controls">
                                {!! Form::text('meta_desc',isset($arr_data['meta_desc'])?$arr_data['meta_desc']:'',['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'255']) !!}
                                <span class='help-block'>{{ $errors->first('meta_desc') }}</span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Meta Keyword</label>
                            <div class="col-sm-9 col-lg-4 controls">
                            {!! Form::text('meta_keyword',isset($arr_data['meta_keyword'])?$arr_data['meta_keyword']:'',['class'=>'form-control','data-rule-maxlength'=>'255']) !!}
                                <span class='help-block'>{{ $errors->first('meta_keyword') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Email<i class="red">*</i></label>
                            <div class="col-sm-9 col-lg-4 controls">
                                {!! Form::text('site_email_address',isset($arr_data['site_email_address'])?$arr_data['site_email_address']:'',['class'=>'form-control', 'data-rule-required'=>'true', 'data-rule-email'=>'true', 'data-rule-maxlength'=>'255']) !!}
                                <span class='help-block'>{{ $errors->first('site_email_address') }}</span>
                            </div>
                        </div>

                         <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Google Plus URL<i class="red">*</i></label>
                            <div class="col-sm-9 col-lg-4 controls">
                                 {!! Form::text('google_plus_url',isset($arr_data['google_plus_url'])?$arr_data['google_plus_url']:'',['class'=>'form-control','data-rule-required'=>'true', 'data-rule-url'=>'true', 'data-rule-maxlength'=>'500']) !!}
                                <span class='help-block'>{{ $errors->first('google_plus_url') }}</span>
                            </div>
                        </div>
  

                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Facebook URL<i class="red">*</i></label>
                            <div class="col-sm-9 col-lg-4 controls">
                                 {!! Form::text('fb_url',isset($arr_data['fb_url'])?$arr_data['fb_url']:'',['class'=>'form-control','data-rule-required'=>'true', 'data-rule-url'=>'true', 'data-rule-maxlength'=>'500']) !!}
                                <span class='help-block'>{{ $errors->first('fb_url') }}</span>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Twitter URL<i class="red">*</i></label>
                            <div class="col-sm-9 col-lg-4 controls">
                                {!! Form::text('twitter_url',isset($arr_data['twitter_url'])?$arr_data['twitter_url']:'',['class'=>'form-control','data-rule-required'=>'true', 'data-rule-url'=>'true', 'data-rule-maxlength'=>'500']) !!}
                                <span class='help-block'>{{ $errors->first('twitter_url') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">YouTube URL<i class="red">*</i></label>
                            <div class="col-sm-9 col-lg-4 controls">
                                {!! Form::text('youtube_url',isset($arr_data['youtube_url'])?$arr_data['youtube_url']:'',['class'=>'form-control','data-rule-required'=>'true', 'data-rule-url'=>'true', 'data-rule-maxlength'=>'500']) !!}
                                <span class='help-block'>{{ $errors->first('youtube_url') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">RSS Feed URL </label>
                            <div class="col-sm-9 col-lg-4 controls">
                                {!! Form::text('rss_feed_url',isset($arr_data['rss_feed_url'])?$arr_data['rss_feed_url']:'',['class'=>'form-control','data-rule-required'=>'true', 'data-rule-url'=>'true', 'data-rule-maxlength'=>'500']) !!}
                                <span class='help-block'>{{ $errors->first('rss_feed_url') }}</span>
                            </div>
                        </div>    

                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Instagram URL<i class="red">*</i></label>
                            <div class="col-sm-9 col-lg-4 controls">
                                 {!! Form::text('instagram_url',isset($arr_data['instagram_url'])?$arr_data['instagram_url']:'',['class'=>'form-control','data-rule-required'=>'true', 'data-rule-url'=>'true', 'data-rule-maxlength'=>'500']) !!}
                                <span class='help-block'>{{ $errors->first('instagram_url') }}</span>
                            </div>
                        </div>  

                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Site Status<i class="red">*</i></label>
                            <div class="col-sm-9 col-lg-4 controls">
                                <select class="form-control" name="site_status" data-rule-required="true">
                                   <option value="0" {{ $arr_data['site_status']==0?'selected':'' }}>Offline</option>     
                                   <option value="1" {{ $arr_data['site_status']==1?'selected':'' }}>Online</option>     
                                </select>
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