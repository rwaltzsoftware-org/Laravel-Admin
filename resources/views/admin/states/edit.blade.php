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
          <i class="fa fa-desktop"></i>
          <a href="{{ $module_url_path }}">{{ $module_title or ''}}</a>
        </span> 
        <span class="divider">
          <i class="fa fa-angle-right"></i>
          <i class="fa fa-list"></i>
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
              <i class="fa fa-text-width"></i>
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
              {{ csrf_field() }}

              <ul  class="nav nav-tabs">
                @include('admin.layout._multi_lang_tab')
              </ul>

              <div  class="tab-content">

                @if(isset($arr_lang) && sizeof($arr_lang)>0)
                @foreach($arr_lang as $lang)
                <?php                          
                          /* Locale Variable */  
                          $locale_title = "";                          
                          if(isset($arr_data['translations'][$lang['locale']]))
                          {
                              $locale_title = $arr_data['translations'][$lang['locale']]['state_title'];
                          }
                      ?>

                <div class="tab-pane fade {{ $lang['locale']=='en'?'in active':'' }}" 
                id="{{ $lang['locale'] }}">

                

                @if($lang['locale']=="en")    

                <div class="form-group">
                  <label class="col-sm-3 col-lg-2 control-label" for="state"> Country Name<i class="red">*</i> </label>
                  <div class="col-sm-6 col-lg-4 controls">
                    @if($lang['locale'] == 'en') 
                    {!!
                        Form::select('country_id', $arr_country,$arr_data['country_id'],['class'=>'form-control','data-rule-required'=>'true'])
                    !!}
                    @endif    
                  </div>
                  <span class='help-block'>{{ $errors->first('country_id_'.$lang['locale']) }}</span>  
                </div>

              @endif

              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="state"> State Title </label>
                <div class="col-sm-6 col-lg-4 controls">

                  @if($lang['locale'] == 'en')        
                  {!! Form::text('state_title_'.$lang['locale'],$arr_data['state_title'],['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'255', 'placeholder'=>'State Title']) !!}
                  @else
                  {!! Form::text('state_title_'.$lang['locale'],$locale_title, ['class'=>'form-control','data-rule-maxlength'=>'255', 'placeholder'=>'State Title']) !!}
                  @endif    
                </div>
                <span class='help-block'>{{ $errors->first('state_title_'.$lang['locale']) }}</span>  
              </div>
            </div>

            @endforeach
            @endif

          </div>
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
@stop                    
