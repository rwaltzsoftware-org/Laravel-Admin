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
      <a call_loader href="{{ $module_url_path_dashbord }}">Dashboard
      </a>
    </li>
    <span class="divider">
      <i class="fa fa-angle-right">
      </i>
      <i class="fa fa-envira">
      </i>
      <a call_loader href="{{ $module_url_path_categories }}">Category
      </a>
    </span>
    <span class="divider">
      <i class="fa fa-angle-right">
      </i>
      <i class="fa fa-tags">
      </i>
      <a call_loader href="{{ $module_url_path_sub_category."/".base64_encode($category_id) }}">Sub-Category
      </a>
    </span> 
    <span class="divider">
      <i class="fa fa-angle-right">
      </i>
      <i class="fa fa-vimeo">
      </i>
      <a call_loader href="{{ $module_url_path."/".base64_encode($sub_category_id) }}">Variety
      </a>
    </span>
    <span class="divider">
      <i class="fa fa-angle-right">
      </i>
      <i class="fa fa-list">
      </i>
    </span>
    <li class="active">{{ $page_title or ''}}
    </li>
  </ul>
</div>

<!-- END Breadcrumb -->
<!-- BEGIN Main Content -->
<div class="row" id="row_id" style="display: none;">
  <div class="col-md-12">
    <div class="box box-navi_blue">
      <div class="box-title">
        <h3>
          <i class="fa fa-text-width">
          </i>
          {{ isset($page_title)?$page_title:"" }}
        </h3>
        <div class="box-tool">
          <a data-action="collapse" href="#">
          </a>
          <a data-action="close" href="#">
          </a>
        </div>
      </div>
      <div class="box-content">
        @include('admin.layout._operation_status')  
        <div class="tabbable">
          {!! Form::open([ 'url' => $module_url_path.'/update/'.base64_encode($arr_variety['id']),
          'method'=>'POST',
          'enctype' =>'multipart/form-data',   
          'class'=>'form-horizontal', 
          'id'=>'validation-form'
          ]) !!} 
          <ul  class="nav nav-tabs">
            @include('admin.layout._multi_lang_tab')
          </ul>
          <div  class="tab-content">
            @if(isset($arr_lang) && sizeof($arr_lang)>0)
            @foreach($arr_lang as $lang)

               <?php 
                          
                  /* Locale Variable */  
                  $locale_category_title = "";
                  

                  if(isset($arr_variety['translations'][$lang['locale']]))
                  {
                      $locale_category_title = $arr_variety['translations'][$lang['locale']]['name'];
                  }
              ?>

            <div class="tab-pane fade {{ $lang['locale']=='en'?'in active':'' }}" 
                 id="{{ $lang['locale'] }}">
              @if($lang['locale']=="en")    
              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="state">Category 
                  <i class="red">*
                  </i>
                </label>
                <div class="col-sm-6 col-lg-4 controls">
                  <select class="form-control" name="category_id" onchange='loadSubCategory(this);' data-rule-required="true"  >
                    <option value="">Select Category
                    </option>
                    @if(isset($arr_all_parent_category) && count($arr_all_parent_category)>0)
                    @foreach($arr_all_parent_category as $key => $value)
                    <option value="{{ $value['id'] }}" 
                            @if($value['id']==$arr_variety['category_id'])
                            selected="" 
                            @endif>{{ $value['category_title'] }}
                    </option>
                    @endforeach
                    @endif
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">Sub Category
                  <i class="red">*
                  </i>
                </label>
                <div class="col-sm-6 col-lg-4 controls"> 
                  <select class="form-control" name="sub_category_id" data-rule-required="true">
                    <option value="">Select Sub-Category
                    </option>
                    @if(isset($arr_sub_category) && count($arr_sub_category)>0)
                    @foreach($arr_sub_category as $key => $value)
                    <option value="{{ $value['id'] }}" 
                            @if($value['id']==$arr_variety['sub_category_id'])
                            selected="" 
                            @endif>{{ $value['category_title'] }}
                    </option>
                    @endforeach
                    @endif
                  </select>
                  {{-- {!!
                  Form::select('sub_category_id', ['0' => 'Select'],"",['class'=>'form-control','data-rule-required'=>'true'])
                  !!} --}}
                  <span class='help-block'>{{ $errors->first('sub_category_id') }}
                  </span>
                </div>
              </div>
              @endif
              <div class="form-group">
                  <label class="col-sm-3 col-lg-2 control-label" for="state"> Title <i class="red">*</i></label>
                  <div class="col-sm-6 col-lg-4 controls">

                      @if($lang['locale'] == 'en')        
                          {!! Form::text('title_'.$lang['locale'],$locale_category_title,['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'255']) !!}
                      @else
                          {!! Form::text('title_'.$lang['locale'],$locale_category_title,['class'=>'form-control']) !!}
                      @endif    
                  </div>
                  <span class='help-block'>{{ $errors->first('title_'.$lang['locale']) }}</span>  
            </div>
              
              <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                  {!! Form::submit('Save',['class'=>'btn btn btn-primary','value'=>'true'])!!}
                </div>
              </div>
              {!! Form::close() !!}
            </div>
        @endforeach
        @endif
          </div>
        </div>
      </div>
      <br>
    </div>
  </div>

<!-- END Main Content -->
@stop                    
<script>  
  var url = "{{ url('/') }}";
  function loadSubCategory(ref)
  {
    var selected_category = jQuery(ref).val();
    jQuery.ajax({
      url:url+'/admin/common/get_category/'+selected_category,
      type:'GET',
      data:'flag=true',
      dataType:'json',
      beforeSend:function()
      {
        jQuery('select[name="sub_category_id"]').attr('disabled','disabled');
      }
      ,
      success:function(response)
      {
        if(response.status=="SUCCESS")
        {
          jQuery('select[name="sub_category_id"]').removeAttr('disabled');
          if(typeof(response.arr_sub_category) == "object")
          {
            var option = '<option value="">Please Select</option>';
            jQuery(response.arr_sub_category).each(function(index,sub_category)
                                                   {
              option+='<option value="'+sub_category.id+'">'+sub_category.category_title+'</option>';
            }
                                                  );
            jQuery('select[name="sub_category_id"]').html(option);
          }
        }
        else
        {
          var option = '<option value="">Please Select</option>';
          jQuery('select[name="sub_category_id"]').html(option);
        }
        return false;
      }
      ,
      error:function(response)
      {
      }
    }
               );
  }
</script>
