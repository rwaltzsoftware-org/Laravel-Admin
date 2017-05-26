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
            <li class="active"><i class="fa fa-edit"></i> {{ $page_title or ''}}</li>
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
           {!! Form::open([ 'url' => $module_url_path.'/update',
                                 'method'=>'POST',
                                 'enctype' =>'multipart/form-data',   
                                 'class'=>'form-horizontal', 
                                 'id'=>'validation-form' 
                                ]) !!} 

           {{ csrf_field() }}

           @if(isset($arr_data) && count($arr_data) > 0)   

           {!! Form::hidden('user_id',isset($arr_data['id']) ? $arr_data['id']: "")!!}

            <div class="form-group" style="margin-top: 25px;">
                  <label class="col-sm-3 col-lg-2 control-label">Firstname<i style="color: red;">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      
                      {!! Form::text('first_name',isset($arr_data['first_name']) ? $arr_data['first_name']: "",['class'=>'form-control','data-rule-required'=>'true', 'placeholder'=>'Enter Firstname' , 'maxlength'=>"255" ]) !!}  
                      
                      <span class="help-block">{{ $errors->first('first_name') }}</span>
                  </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">Lastname<i style="color: red;">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      
                      {!! Form::text('last_name',isset($arr_data['last_name']) ? $arr_data['last_name']: "",['class'=>'form-control','data-rule-required'=>'true', 'placeholder'=>'Enter Lastname' , 'maxlength'=>"255"]) !!}  

                      <span class="help-block">{{ $errors->first('last_name') }}</span>
                  </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">Email<i style="color: red;">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      
                      {!! Form::text('email',isset($arr_data['email']) ? $arr_data['email']: "",['class'=>'form-control', 'placeholder'=>'Enter Email' ,'readonly'=>'true', 'maxlength'=>"255" ]) !!}  

                      <span class="help-block">{{ $errors->first('email') }}</span>
                  </div>
            </div>  

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">Phone<i style="color: red;">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      
                      {!! Form::text('text',isset($arr_data['phone']) ? $arr_data['phone']: "",['class'=>'form-control', 'placeholder'=>'Enter Phone No','name'=>'phone','data-rule-required'=>'true', 'data-rule-digits' => 'true', 'maxlength'=>"15" ,'minlength'=>"6" ]) !!}  

                      <span class="help-block">{{ $errors->first('phone') }}</span>
                  </div>
            </div>

            <div class="form-group" style="">
                <label class="col-sm-3 col-lg-2 control-label">Country<i style="color: red;">*</i></label>
                <div class="col-sm-9 col-lg-4 controls" >
                    <select class="form-control" id="country" name="country" data-rule-required='true' onchange="changeCountryRestriction(this)" >
                      @if(isset($arr_country) && count($arr_country)>0)
                        @foreach($arr_country as $key => $value)
                          <option value="{{ $value['country_code'] }}" <?php if(isset($arr_data['country']) &&  $value['country_code'] == $arr_data['country']) {echo 'selected=selected'; }  ?> >{{ $value['country_name'] }}</option>
                        @endforeach
                      @endif
                    </select>
                    <span class="help-block">{{ $errors->first('role') }}</span>
                </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">Street Address<i style="color: red;">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >

                      {!! Form::text('street_address',isset($arr_data['street_address']) ? $arr_data['street_address']: "",['class'=>'form-control','data-rule-required'=>'true', 'placeholder'=>'Enter Street Address', 'id'=>"autocomplete"]) !!}

                      <span class="help-block">{{ $errors->first('street_address') }}</span>
                  </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">State</label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      
                      {!! Form::text('state',isset($arr_data['state']) ? $arr_data['state']: "",['class'=>'form-control','data-rule-required'=>'', 'placeholder'=>'State', 'id'=>"administrative_area_level_1" ,'readonly'=>'']) !!}

                      <span class="help-block">{{ $errors->first('state') }}</span>
                  </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">City</label>
                  <div class="col-sm-9 col-lg-4 controls" >
                     
                     {!! Form::text('city',isset($arr_data['city']) ? $arr_data['city']: "",['class'=>'form-control','data-rule-required'=>'', 'placeholder'=>'City', 'id'=>"locality" ,'readonly'=>'']) !!}

                      <span class="help-block">{{ $errors->first('city') }}</span>
                  </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">Zip Code</label>
                  <div class="col-sm-9 col-lg-4 controls" >

                     {!! Form::text('zipcode',isset($arr_data['zipcode']) ? $arr_data['zipcode']: "",['class'=>'form-control','data-rule-required'=>'', 'placeholder'=>'Zip Code', 'id'=>"postal_code" , 'maxlength'=>"12", 'minlength'=>"4"]) !!}
                    
                      <span class="help-block">{{ $errors->first('zipcode') }}</span>
                  </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label">Profile Image<i style="color: red;">*</i> </label>
              <div class="col-sm-9 col-lg-10 controls">
                 <div class="fileupload fileupload-new" data-provides="fileupload">
                   <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                      <img src={{ $user_profile_public_img_path.$arr_data['profile_image']}} alt="" />  
                  </div>
                    <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
                         <img src={{ $user_profile_public_img_path.$arr_data['profile_image']}} alt="" />  
                    </div>
                    <div>
                       <span class="btn btn-default btn-file"><span class="fileupload-new" >Select Image</span> 
                       <span class="fileupload-exists">Change</span>
                       
                       {!! Form::file('profile_image',['id'=>'profile_image','class'=>'file-input','data-rule-required'=>'']) !!}

                       </span> 
                       <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                       <span>
                       </span> 
                    </div>
                 </div>
                  <i style="color:#ff6666;">Please use 140 x 140 pixel image for best result ,<br/> allowed only JPG, JPEG and PNG image</i>
                  <span class='help-block'><b>{{ $errors->first('profile_image') }}</b></span>  
              </div>
            </div>



            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
               
                {!! Form::submit('Update',['class'=>'btn btn btn-primary','value'=>'true'])!!}
                &nbsp;
                <a class="btn btn-primary" href="{{ $module_url_path }}">Back</a>
              </div>
            </div>

            @else 
              <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                  <h3><strong>No Record found..</strong></h3>     
                </div>
              </div>
            @endif
    
          {!! Form::close() !!}
      </div>
    </div>
  </div>
  
  <!-- END Main Content -->


<script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCccvQtzVx4aAt05YnfzJDSWEzPiVnNVsY&libraries=places&callback=initAutocomplete"
        async defer>
</script>

<script>  

$(document).ready(function () {
  changeCountryRestriction('#country');
});


  var glob_autocomplete;
  var glob_component_form = 
  {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'long_name',
    postal_code: 'short_name'
  };

  var glob_options = {};
  glob_options.types = ['address'];

  function changeCountryRestriction(ref)
  {
    var country_code = $(ref).val();
    destroyPlaceChangeListener(autocomplete);
    // load states function
    // loadStates(country_code);  

    glob_options.componentRestrictions = {country: country_code}; 

    initAutocomplete(country_code);

    glob_autocomplete = false;
    glob_autocomplete = initGoogleAutoComponent($('#autocomplete')[0],glob_options,glob_autocomplete);
  }


  function initAutocomplete(country_code) 
  {
    glob_options.componentRestrictions = {country: country_code}; 

    glob_autocomplete = false;
    glob_autocomplete = initGoogleAutoComponent($('#autocomplete')[0],glob_options,glob_autocomplete);
  }


  function initGoogleAutoComponent(elem,options,autocomplete_ref)
  {
    autocomplete_ref = new google.maps.places.Autocomplete(elem,options);
    autocomplete_ref = createPlaceChangeListener(autocomplete_ref,fillInAddress);

    return autocomplete_ref;
  }
  

  function createPlaceChangeListener(autocomplete_ref,fillInAddress)
  {
    autocomplete_ref.addListener('place_changed', fillInAddress);
    return autocomplete_ref;
  }

  function destroyPlaceChangeListener(autocomplete_ref)
  {
    google.maps.event.clearInstanceListeners(autocomplete_ref);
  }

  function fillInAddress() 
  {
    // Get the place details from the autocomplete object.
    var place = glob_autocomplete.getPlace();
    console.log(place)  ;
    for (var component in glob_component_form) 
    {
        $("#"+component).val("");
        $("#"+component).attr('disabled',false);
    }
    
    if(place.address_components.length > 0 )
    {
      $.each(place.address_components,function(index,elem)
      {
          var addressType = elem.types[0];
          if(glob_component_form[addressType])
          {
            var val = elem[glob_component_form[addressType]];
            $("#"+addressType).val(val) ;  
          }
      });  
    }
  }

</script>     
  

@stop                    
