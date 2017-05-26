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
                <i class="fa fa-desktop"></i>
                <a href="{{ $module_url_path }}">{{ $module_title or ''}}</a>
            </li>   
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active"><i class="fa fa-home"></i> {{ $page_title or ''}}</li>
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
                <ul id="myTab1" class="nav nav-tabs">
                  @if(isset($arr_lang) && sizeof($arr_lang)>0)
                  @foreach($arr_lang as $lang)
                  <li class="{{ $lang['locale']=='en'?'active':'' }}">
                    <?php 
                    $is_linked_enabled = $lang['locale']=='en'?TRUE:FALSE;
                    ?>
                    <a href="#{{$lang['locale']}}" 
                    {{ $lang['locale']=='en'?'data-toggle="tab"':'' }} >
                    <i class="fa fa-home"></i> 
                    {{$lang['title']}} 
                  </a>
                </li>
                @endforeach
                @endif
              </ul>

              {!! Form::open([ 'url' => $module_url_path.'/store',
              'method'=>'POST',
              'enctype' =>'multipart/form-data',   
              'class'=>'form-horizontal', 
              'id'=>'validation-form' 
              ]) !!}              

              {{ csrf_field() }}  

              <div id="myTabContent1" class="tab-content">

               @if(isset($arr_lang) && sizeof($arr_lang)>0)
               @foreach($arr_lang as $lang)

               <div class="tab-pane fade {{ $lang['locale']=='en'?'in active':'' }}" 
               id="{{ $lang['locale'] }}">

              @if($lang['locale']=="en")
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label" for="country_code">Country <i class="red">*</i></label>
                    <div class="col-sm-6 col-lg-4 controls">
                      @if($lang['locale'] == 'en') 
                      {!!
                          Form::select('country_id',$arr_country,"",['class'=>'form-control','data-rule-required'=>'true', 'onchange'=>'loadStates(this)'])
                      !!}
                    @endif
                        
                        <span class='help-block'>{{ $errors->first('country_id') }}</span>
                    </div>
                </div>

                 <div class="form-group">
                  <label class="col-sm-3 col-lg-2 control-label">State/Region<i class="red">*</i></label>
                  <div class="col-sm-6 col-lg-4 controls">

                    @if($lang['locale'] == 'en') 
                      {!!
                          Form::select('state_id', ['0' => 'Select'],"",['class'=>'form-control','data-rule-required'=>'true'])
                      !!}
                    @endif
                       <span class='help-block'>{{ $errors->first('state_id') }}</span>
                  </div>
               </div>

              @endif
               
               <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" >City<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-6 controls">
                  @if($lang['locale'] == 'en')        
                    {!! Form::text('city_title_'.$lang['locale'],old('city_title_'.$lang['locale']),['class'=>'form-control','data-rule-required'=>'true','placeholder'=>'City Title']) !!}
                    @else
                    {!! Form::text('city_title_'.$lang['locale'],old('city_title_'.$lang['locale']),['class'=>'form-control','placeholder'=>'City Title']) !!}
                  @endif
                  <span class='help-block'>{{ $errors->first('city_title_'.$lang['locale']) }}</span>
                </div>
              </div>         

            </div>
            @endforeach
            @endif
          </div>

          <br>
          <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
              <input type="submit"  class="btn btn-primary" value="Save" >
            </div>
          </div>
        {!! Form::close() !!}
      </div>
      
      
    </div>
  </div>
  </div>

  <!-- END Main Content -->

<script type="text/javascript">
    var url = "{{ url('/') }}";
    function loadStates(ref)
     {
        var selected_country = jQuery(ref).val();

        jQuery.ajax({
                        url:url+'/admin/common/get_states/'+selected_country,
                        type:'GET',
                        data:'flag=true',
                        dataType:'json',
                        beforeSend:function()
                        {
                            jQuery('select[name="state"]').attr('disabled','disabled');
                        },
                        success:function(response)
                        {
                            if(response.status=="SUCCESS")
                            {
                              
                                jQuery('select[name="state_id"]').removeAttr('disabled');
                                if(typeof(response.arr_state) == "object")
                                {
                                   var option = '<option value="">Please Select</option>'; 
                                   jQuery(response.arr_state).each(function(index,states)
                                   {   
                                    
                                        option+='<option value="'+states.id+'">'+states.state_title+'</option>';
                                   });

                                   jQuery('select[name="state_id"]').html(option);
                                }
                            }
                            else
                            {
                              var option = '<option value="">Please Select</option>'; 
                              jQuery('select[name="state_id"]').html(option);
                            }
                            return false;
                        },
                        error:function(response)
                        {
                         
                        }
        });
     }    
</script>

     


@stop                    
