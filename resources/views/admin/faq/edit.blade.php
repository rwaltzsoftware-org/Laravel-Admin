    @extends('admin.layout.master')                

    @section('main_content')
    <!-- BEGIN Page Title -->

    {{-- <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/data-tables/latest/dataTables.bootstrap.min.css"> --}}
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
                <i class="fa fa-question-circle"></i>
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

          <div class="box">
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
                <ul  class="nav nav-tabs">
                   @include('admin.layout._multi_lang_tab')
                </ul>
                
                
                {!! Form::open([ 'url' => $module_url_path.'/update/'.$enc_id,
                                 'method'=>'POST',
                                 'class'=>'form-horizontal',
                                 'id'=>'validation-form' 

                                ]) !!} 

                  
                <div  class="tab-content">
                  
                  @if(isset($arr_lang) && sizeof($arr_lang)>0)
                    @foreach($arr_lang as $lang)

                    <?php 
                        
                        /* Locale Variable */  
                        $locale_question = "";
                        $locale_answer   = "";

                        if(isset($arr_data['translations'][$lang['locale']]))
                        {
                          $locale_question = $arr_data['translations'][$lang['locale']]['question'];
                           $locale_answer  = $arr_data['translations'][$lang['locale']]['answer'];
                        }
                    ?>


                      <div class="tab-pane fade {{ $lang['locale']=='en'?'in active':'' }}" 
                               id="{{ $lang['locale'] }}">

                          <div class="form-group">
                                <label class="col-sm-3 col-lg-2 control-label" for="state"> Question
                                    @if($lang['locale'] == 'en') 
                                        <i class="red">*</i>
                                     @endif
                                 </label>
                                <div class="col-sm-6 col-lg-8 controls">
                                    @if($lang['locale'] == 'en')        
                                        {!! Form::text('question_'.$lang['locale'],$locale_question,['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'500', 'placeholder'=>'Question']) !!}
                                    @else
                                        {!! Form::text('question_'.$lang['locale'],$locale_question,['class'=>'form-control', 'placeholder'=>'Question']) !!}
                                    @endif    
                                </div>
                                <span class='help-block'>{{ $errors->first('question_'.$lang['locale']) }}</span>  
                          </div>

                          <div class="form-group">
                                <label class="col-sm-3 col-lg-2 control-label" for="state"> Answer
                                      @if($lang['locale'] == 'en') 
                                        <i class="red">*</i>
                                     @endif
                                 </label>
                                <div class="col-sm-6 col-lg-8 controls">
                                    @if($lang['locale'] == 'en')        
                                        {!! Form::textarea('answer_'.$lang['locale'],$locale_answer,['class'=>'form-control','data-rule-required'=>'true', 'placeholder'=>'Answer']) !!}
                                    @else
                                        {!! Form::textarea('answer_'.$lang['locale'],$locale_answer,['class'=>'form-control', 'placeholder'=>'Answer']) !!}
                                    @endif    
                                </div>
                                <span class='help-block'>{{ $errors->first('answer_'.$lang['locale']) }}</span>  
                          </div>

                        </div>

                      @endforeach
                  @endif
                  
                </div>
                   <br>
                   <div class="form-group">
                          <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                            {!! Form::submit('Update',['class'=>'btn btn btn-primary','value'=>'true'])!!}
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
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image ',
        content_css: [
          '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
          '//www.tinymce.com/css/codepen.min.css'
        ]
      }
                  );
    }
                     );
  </script>

@stop                    
