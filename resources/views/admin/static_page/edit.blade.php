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
          <i class="fa fa-sitemap"></i>
          <a href="{{ $module_url_path }}">{{ $module_title or ''}}</a>
        </span> 
        <span class="divider">
          <i class="fa fa-angle-right"></i>
          <i class="fa fa-edit"></i>
        </span>
        <li class="active">{{ $page_title or ''}}</li>
      </ul>
    </div>
    <!-- END Breadcrumb -->


    <!-- BEGIN Main Content -->
    <div class="row">
      <div class="col-md-12">

        <div class="box {{ $theme_color }}">
          <div class="box-title">
            <h3>
              <i class="fa fa-edit"></i>
              {{ isset($page_title)?$page_title:"" }}
            </h3>
            <div class="box-tool">
              <a data-action="collapse" href="#"></a>
              <a data-action="close" href="#"></a>
            </div>
          </div>
          <div class="box-content">

            @include('admin.layout._operation_status') 

            <div class="tabbable">

              {!! Form::open([ 'url' => $module_url_path.'/update/'.$enc_id,
               'method'=>'POST',
               'enctype' =>'multipart/form-data',   
               'class'=>'form-horizontal', 
               'id'=>'validation-form' 
               ]) !!} 

               <ul  class="nav nav-tabs">
                @include('admin.layout._multi_lang_tab')
              </ul>                                
              <div id="myTabContent1" class="tab-content">

                @if(isset($arr_lang) && sizeof($arr_lang)>0)
                @foreach($arr_lang as $lang)
                 <?php 
                      /* Locale Variable */  
                      $locale_page_title = "";
                      $locale_meta_keyword = "";
                      $locale_meta_desc = "";
                      $locale_page_desc = "";
                      

                      if(isset($arr_static_page['translations'][$lang['locale']]))
                      {
                          $locale_page_title = $arr_static_page['translations'][$lang['locale']]['page_title'];
                          $locale_meta_keyword = $arr_static_page['translations'][$lang['locale']]['meta_keyword'];
                          $locale_meta_desc = $arr_static_page['translations'][$lang['locale']]['meta_desc'];
                          $locale_page_desc = $arr_static_page['translations'][$lang['locale']]['page_desc'];
                      }
                  ?>
                <div class="tab-pane fade {{ $lang['locale']=='en'?'in active':'' }}"
                id="{{ $lang['locale'] }}">

                <div class="form-group">
                  <label class="col-sm-3 col-lg-2 control-label" for="page_title">Page Title
                       @if($lang['locale'] == 'en') 
                          <i class="red">*</i>
                       @endif
                  </label>
                  <div class="col-sm-6 col-lg-4 controls">
                    

                    @if($lang['locale'] == 'en')        
                        {!! Form::text('page_title_'.$lang['locale'],$locale_page_title,['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'255','placeholder'=>'Page Title']) !!}
                    @else
                        {!! Form::text('page_title_'.$lang['locale'],$locale_page_title,['class'=>'form-control','placeholder'=>'Page Title']) !!}
                    @endif    


                    <span class='help-block'>{{ $errors->first('page_name') }}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 col-lg-2 control-label" for="meta_keyword">Meta Keyword
                       @if($lang['locale'] == 'en') 
                          <i class="red">*</i>
                       @endif
                  </label>
                  <div class="col-sm-6 col-lg-4 controls">
                    

                    @if($lang['locale'] == 'en')        
                        {!! Form::text('meta_keyword_'.$lang['locale'],$locale_meta_keyword,['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'255','placeholder'=>'Meta Keyword']) !!}
                    @else
                        {!! Form::text('meta_keyword_'.$lang['locale'],$locale_meta_keyword,['class'=>'form-control','placeholder'=>'Meta Keyword']) !!}
                    @endif

                    <span class='help-block'>{{ $errors->first('meta_keyword_') }}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 col-lg-2 control-label" for="meta_desc">Meta Description
                       @if($lang['locale'] == 'en') 
                          <i class="red">*</i>
                       @endif
                  </label>
                  <div class="col-sm-6 col-lg-4 controls">

                    @if($lang['locale'] == 'en')        
                        {!! Form::text('meta_desc_'.$lang['locale'],$locale_meta_desc,['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'255','placeholder'=>'Meta Description']) !!}
                    @else
                        {!! Form::text('meta_desc_'.$lang['locale'],$locale_meta_desc,['class'=>'form-control','placeholder'=>'Meta Description']) !!}
                    @endif


                    <span class='help-block'>{{ $errors->first('meta_desc_'.$lang['locale']) }}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 col-lg-2 control-label" for="page_desc">Page Content
                       @if($lang['locale'] == 'en') 
                          <i class="red">*</i>
                       @endif
                  </label>
                  <div class="col-sm-6 col-lg-8 controls">
                    

                    @if($lang['locale'] == 'en')        
                        {!! Form::textarea('page_desc_'.$lang['locale'],$locale_page_desc,['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'1000','placeholder'=>'Page Content']) !!}
                    @else
                        {!! Form::textarea('page_desc_'.$lang['locale'],$locale_page_desc,['class'=>'form-control','placeholder'=>'Page Content']) !!}
                    @endif

                    <span class='help-block'>{{ $errors->first('page_desc_'.$lang['locale']) }}</span>
                  </div>
                </div>
              </div>
              @endforeach
              @endif
            </div>
            <br>
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                {!! Form::submit('Update',['class'=>'btn btn btn-primary','value'=>'true','onclick'=>'saveTinyMceContent()'])!!}
              </div>
            </div>
            {!! Form::close() !!}
          </div>

        </div>
      </div>
    </div>

  <!-- END Main Content -->

  <script type="text/javascript">

    function saveTinyMceContent()
    {
      tinyMCE.triggerSave();
    }

    $(document).ready(function()
    {
      tinymce.init({
        selector: 'textarea',
        height:350,
        plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code'
        ],
        valid_elements : '*[*]',
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        content_css: [
        '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
        '//www.tinymce.com/css/codepen.min.css'
        ]
      });  
    });
  </script>

  @stop
