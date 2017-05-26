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
            <li class="active"><i class="fa fa-plus-square-o"></i> {{ $page_title or ''}}</li>
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

            <div class="form-group" style="margin-top: 25px;">
                  <label class="col-sm-3 col-lg-2 control-label">Firstname<i style="color: red;">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      <input type="text" class="form-control" name="first_name" placeholder="Enter Firstname" data-rule-required="true" value="{{ old('first_name') }}" />
                      <span class="help-block">{{ $errors->first('first_name') }}</span>
                  </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">Lastname<i style="color: red;">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      <input type="text" class="form-control" name="last_name" placeholder="Enter Lastname" data-rule-required="true" value="{{ old('last_name') }}" />
                      <span class="help-block">{{ $errors->first('last_name') }}</span>
                  </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">Email<i style="color: red;">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      <input type="text" class="form-control" name="email" placeholder="Enter Email" data-rule-required="true" data-rule-email="true" value="{{ old('email') }}" />
                      <span class="help-block">{{ $errors->first('email') }}</span>
                  </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">Phone<i style="color: red;">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      
                      <input type="text" class="form-control" name="phone" placeholder="Enter Phone No." data-rule-required="true" data-rule-digits="true" maxlength="15" minlength="6" value="{{ old('phone') }}" />

                      <span class="help-block">{{ $errors->first('phone') }}</span>
                  </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">Password<i style="color: red;">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      <input type="password" class="form-control" name="password" placeholder="Enter Password" data-rule-required="true" value="{{ old('password') }}" minlength="6" />
                      <span class="help-block">{{ $errors->first('password') }}</span>
                  </div>
            </div>
            
            <div class="form-group" style="">
                <label class="col-sm-3 col-lg-2 control-label">Country<i style="color: red;">*</i></label>
                <div class="col-sm-9 col-lg-4 controls" >
                    <select class="form-control"  name="country" data-rule-required="true" onchange="changeCountryRestriction(this)" >
                      <option value="">--Select Country--</option>
                      @if(isset($arr_country) && count($arr_country)>0)
                        @foreach($arr_country as $key => $value)
                          <option value="{{ $value['country_code'] }}">{{ $value['country_name'] }}</option>
                        @endforeach
                      @endif
                    </select>
                    <span class="help-block">{{ $errors->first('role') }}</span>
                </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">Street Address<i style="color: red;">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      <input type="text" class="form-control" name="street_address" id="autocomplete"  placeholder="Enter Street Address" data-rule-required="true" value="{{ old('street_address') }}" />
                      <span class="help-block">{{ $errors->first('street_address') }}</span>
                  </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">State</label>
                  <div class="col-sm-9 col-lg-4 controls" >
                    <input type="text" class="form-control" name="state" id="administrative_area_level_1"  
                       placeholder="State" value="{{ old('state') }}" readonly="" />   
                      <span class="help-block">{{ $errors->first('state') }}</span>
                  </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">City</label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      <input type="text" class="form-control" name="city"  id="locality" placeholder="City" readonly=""  data-rule-required=""  />
                      <span class="help-block">{{ $errors->first('city') }}</span>
                  </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">Zip Code </label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      <input type="text" class="form-control" name="zipcode" id="postal_code" data-rule-required="" placeholder="Zip Code"  minlength="4" maxlength="12"  />
                      <span class="help-block">{{ $errors->first('zipcode') }}</span>
                  </div>
            </div>


             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label"> Profile Image <i style="color: red;">*</i></label>
                <div class="col-sm-9 col-lg-10 controls">
                   <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                          
                      </div>
                      <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div>
                         <span class="btn btn-default btn-file"><span class="fileupload-new" >Select Image</span> 
                         <span class="fileupload-exists">Change</span>
                         
                         {!! Form::file('profile_image',['id'=>'image_proof','class'=>'file-input','data-rule-required'=>'true']) !!}

                         </span> 
                         <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                         <span>
                         </span> 
                      </div>
                   </div>
                    <span class='help-block'>{{ $errors->first('profile_image') }}</span>  
                </div>
            </div>


            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
               
                {!! Form::submit('Save',['class'=>'btn btn btn-primary','value'=>'true'])!!}
                &nbsp;
                <a class="btn btn-primary" href="{{ $module_url_path }}">Back</a>
              </div>
            </div>
    
          {!! Form::close() !!}
      </div>
    </div>
  </div>
  
  <!-- END Main Content -->


<script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCccvQtzVx4aAt05YnfzJDSWEzPiVnNVsY&libraries=places&callback=initAutocomplete"
        async defer>
</script>

<script>  
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
