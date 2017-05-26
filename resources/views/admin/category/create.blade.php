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
                <i class="fa fa-list-alt"></i>
                <a href="{{ url($admin_panel_slug.'/categories') }}">{{ $module_title or ''}}</a>
            </span> 
            <span class="divider">
                <i class="fa fa-angle-right"></i>
                  <i class="fa fa-plus-square-o"></i>
            </span>
            <li class="active">{{ $page_title or ''}}</li>
        </ul>
    </div>
    <!-- END Breadcrumb -->


    <!-- BEGIN Main Content -->
    <div class="row">
      <div class="col-md-12">

          <div class="box ">
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

			<div class="tabbable">

                {!! Form::open([ 'url' => $admin_panel_slug.'/categories/store',
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

                            <div class="tab-pane fade {{ $lang['locale']=='en'?'in active':'' }}" 
                            	 id="{{ $lang['locale'] }}">
	
								    @if($lang['locale']=="en")		
                                    
                        <div class="form-group">
                              <label class="col-sm-3 col-lg-2 control-label" for="state">Category <i class="red">*</i></label>
                              <div class="col-sm-6 col-lg-4 controls">
                               
                                {!! Form::select('parent', $arr_parent_category_options, $parent_id, ['class'=>'form-control','data-rule-required'=>'required']) !!}

                              </div>
                        </div>

									     <div class="form-group">
						                <label class="col-sm-3 col-lg-2 control-label"> Image <i class="red">*</i> </label>
						                <div class="col-sm-9 col-lg-10 controls">
						                   <div class="fileupload fileupload-new" data-provides="fileupload">
						                      <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
						                          
						                      </div>
						                      <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
						                      <div>
						                         <span class="btn btn-default btn-file"><span class="fileupload-new" >Select image</span> 
						                         <span class="fileupload-exists">Change</span>
						                         
                                                 {!! Form::file('image',['id'=>'ad_image','class'=>'file-input']) !!}


                                                 </span> 
						                         <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>

						                         <span  >
						                          
						                         </span> 

						                      </div>
						                   </div>
						                    <span class='help-block'>{{ $errors->first('image') }}</span>  
						                </div>
						            </div>	
					            @endif

                                <div class="form-group">
                                      <label class="col-sm-3 col-lg-2 control-label" for="state"></label>
                                      <div class="col-sm-6 col-lg-4 controls">
                                      <i class="red">Image should be in PNG Format (70 X 70).
                                      </i> 
                                      </div>
                                      <span class='help-block'>{{ $errors->first('title_'.$lang['locale']) }}</span>  
                                </div>


		                        <div class="form-group">
	                                  <label class="col-sm-3 col-lg-2 control-label" for="state"> Title <i class="red">*</i></label>
	                                  <div class="col-sm-6 col-lg-4 controls">

                                        @if($lang['locale'] == 'en')        
                                            {!! Form::text('title_'.$lang['locale'],old('title_'.$lang['locale']),['class'=>'form-control','data-rule-required'=>'true','data-rule-maxlength'=>'255' , 'placeholder'=>'Enter Title']) !!}
                                        @else
                                            {!! Form::text('title_'.$lang['locale'],old('title_'.$lang['locale']) , ['class'=>'form-control','data-rule-required'=>'','data-rule-maxlength'=>'255' , 'placeholder'=>'Enter Title']) !!}
                                        @endif    
	                                  </div>
                                      <span class='help-block'>{{ $errors->first('title_'.$lang['locale']) }}</span>  
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
