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
            <li class="active"><i class="fa fa-user"></i> {{ $page_title or ''}}</li>
        </ul>
    </div>
    <!-- END Breadcrumb -->



    <!-- BEGIN Main Content -->
    <div class="row">
      <div class="col-md-12">
          <div class="box {{ $theme_color }}">
            <div class="box-title">
              <h3>
                <i class="fa fa-user"></i>
                {{ isset($page_title)?$page_title:"" }}
              </h3>
              <div class="box-tool">
                <a data-action="collapse" href="#"></a>
                <a data-action="close" href="#"></a>
              </div>
            </div>
            <div class="box-content">

          @include('admin.layout._operation_status')  
           {!! Form::open([ 'url' => $module_url_path.'/owner_store',
                                 'method'=>'POST',
                                 'enctype' =>'multipart/form-data',   
                                 'class'=>'form-horizontal', 
                                 'id'=>'validation-form' 
                                ]) !!} 

           {{ csrf_field() }}

            {!! Form::hidden('user_id',isset($arr_owner['user_id']) ? $arr_owner['user_id']: "",[]) !!}

            <div class="form-group" style="margin-top: 25px;">
                  <label class="col-sm-3 col-lg-2 control-label">Company Name<i style="color: red;">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >

                       {!! Form::text('company_name',isset($arr_owner['company_name']) ? $arr_owner['company_name']: "",['class'=>'form-control','data-rule-required'=>'true', 'placeholder'=>'Enter Company Name']) !!}

                      <span class="help-block">{{ $errors->first('company_name') }}</span>
                  </div>
            </div>

            <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">Account Phone 1<i style="color: red;">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      
                      {!! Form::text('account_phone_1',isset($arr_owner['account_phone_1']) ? $arr_owner['account_phone_1']: "",['class'=>'form-control','data-rule-required'=>'true', 'placeholder'=>'Enter Account Phone 1', 'data-rule-minlength'=>'6', 'data-rule-maxlength'=>'20']) !!}
                      
                      <span class="help-block">{{ $errors->first('account_phone_1') }}</span>
                  </div>
            </div>

            {{-- <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">Account Phone 2</label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      
                      {!! Form::text('account_phone_2',isset($arr_owner['account_phone_2']) ? $arr_owner['account_phone_2']: "",['class'=>'form-control','data-rule-required'=>'', 'placeholder'=>'Enter Account Phone 2', 'data-rule-minlength'=>'6', 'data-rule-maxlength'=>'20']) !!}
                      <span class="help-block">{{ $errors->first('email') }}</span>
                  </div>
            </div> --}}


             <hr/>


            <div class="form-group"> 
            <label class="col-sm-3 col-lg-2 control-label" ></label>
              <div class="col-sm-3 col-lg-3 controls">
                  <h4><b>Billing Address</b></h4>
                </div>
            </div>

            <div id="">
              <div class="form-group" style="">
                  <label class="col-sm-3 col-lg-2 control-label">Country<i style="color: red;">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      <select class="form-control"  name="country"  id="country" disabled="true">
                        @if(isset($arr_country) && count($arr_country)>0)
                          @foreach($arr_country as $key => $value)
                            <option value="CL" <?php if($value['country_code'] == 'CL') {echo 'selected=selected'; }  ?> >{{ $value['country_name'] }}</option>
                          @endforeach
                        @endif
                      </select>
                      <span class="help-block">{{ $errors->first('role') }}</span>
                  </div>
              </div>

              <div class="form-group" style="">
                    <label class="col-sm-3 col-lg-2 control-label">Street Address<i style="color: red;">*</i></label>
                    <div class="col-sm-9 col-lg-4 controls" >

                      {!! Form::text('street_address',isset($arr_billing_address['street_address_1']) ? $arr_billing_address['street_address_1']: "",['class'=>'form-control','data-rule-required'=>'true', 'placeholder'=>'Enter Street Address', 'id'=>"autocomplete"]) !!}

                        <span class="help-block">{{ $errors->first('street_address') }}</span>
                    </div>
              </div>


              <div class="form-group" style="">
                    <label class="col-sm-3 col-lg-2 control-label">State</label>
                    <div class="col-sm-9 col-lg-4 controls" >
                        
                        {!! Form::text('state',isset($arr_billing_address['state']) ? $arr_billing_address['state']: "",['class'=>'form-control','data-rule-required'=>'', 'placeholder'=>'State', 'id'=>"administrative_area_level_1" ,'readonly'=>'true']) !!}

                        <span class="help-block">{{ $errors->first('state') }}</span>
                    </div>
              </div>

              <div class="form-group" style="">
                    <label class="col-sm-3 col-lg-2 control-label">City</label>
                    <div class="col-sm-9 col-lg-4 controls" >
                       
                       {!! Form::text('city',isset($arr_billing_address['city']) ? $arr_billing_address['city']: "",['class'=>'form-control','data-rule-required'=>'', 'placeholder'=>'City', 'id'=>"locality" ,'readonly'=>'']) !!}

                        <span class="help-block">{{ $errors->first('city') }}</span>
                    </div>
              </div>

              <div class="form-group" style="">
                    <label class="col-sm-3 col-lg-2 control-label">Zip Code</label>
                    <div class="col-sm-9 col-lg-4 controls" >

                       {!! Form::text('zipcode',isset($arr_billing_address['zipcode']) ? $arr_billing_address['zipcode']: "",['class'=>'form-control','data-rule-digits'=>'true', 'placeholder'=>'Zip Code', 'id'=>"postal_code", 'data-rule-minlength'=>'6', 'data-rule-maxlength'=>'20']) !!}
                      
                        <span class="help-block">{{ $errors->first('zipcode') }}</span>
                    </div>
              </div>
            </div>

            <hr/>
            <div class="form-group"> 
            <label class="col-sm-3 col-lg-2 control-label" ></label>
              <div class="col-sm-3 col-lg-3 controls">
                  <h4><b>Banking Details</b></h4>
                </div>
            </div>

            <div class="form-group" style="">
                    <label class="col-sm-3 col-lg-2 control-label">RUT No<i class="red">*</i></label>
                    <div class="col-sm-9 col-lg-4 controls" >
                        
                        {!! Form::text('rut_no',isset($arr_user_bank_details['rut_number']) ? $arr_user_bank_details['rut_number']: "",['class'=>'form-control','data-rule-required'=>'true', 'data-rule-digits'=>'true', 'placeholder'=>'RUT No.']) !!}
                        <span class="help-block">{{ $errors->first('rut_no') }}</span>
                    </div>
              </div>

              <div class="form-group" style="">
                    <label class="col-sm-3 col-lg-2 control-label">Account No<i class="red">*</i></label>
                    <div class="col-sm-9 col-lg-4 controls" >
                        
                        {!! Form::text('account_no',isset($arr_user_bank_details['bank_acc_no']) ? $arr_user_bank_details['bank_acc_no']: "",['class'=>'form-control','data-rule-required'=>'true', 'data-rule-digits'=>'true', 'placeholder'=>'Account No.']) !!}
                        <span class="help-block">{{ $errors->first('account_no') }}</span>
                    </div>
              </div>

            
            <div class="form-group" style="">
                    <label class="col-sm-3 col-lg-2 control-label">Bank<i class="red">*</i></label>
                    <div class="col-sm-9 col-lg-4 controls" >
                        
                        {!! Form::text('bank',isset($arr_user_bank_details['bank_name']) ? $arr_user_bank_details['bank_name']: "",['class'=>'form-control','data-rule-required'=>'true', 'placeholder'=>'Bank Name']) !!}
                        <span class="help-block">{{ $errors->first('bank') }}</span>
                    </div>
              </div>

               <div class="form-group" style="">
                    <label class="col-sm-3 col-lg-2 control-label">Email<i class="red">*</i></label>
                    <div class="col-sm-9 col-lg-4 controls" >
                        
                        {!! Form::text('email',isset($arr_user_bank_details['bank_acc_email']) ? $arr_user_bank_details['bank_acc_email']: "",['class'=>'form-control','data-rule-required'=>'true', 'data-rule-email'=>'true','placeholder'=>'Email']) !!}
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    </div>
              </div>

              <div class="form-group" style="">
                    <label class="col-sm-3 col-lg-2 control-label">Account Type<i class="red">*</i></label>
                    <div class="col-sm-9 col-lg-4 controls" >
                        <select name="account_type" class="form-control"> 
                          <option value="1" @if($arr_user_bank_details['bank_acc_type']==1){{ 'selected' }}@endif>Ahorro</option>
                          <option value="2" @if($arr_user_bank_details['bank_acc_type']==2){{ 'selected' }}@endif>Vista</option>
                        </select>
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    </div>
              </div>

            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
               
                {!! Form::submit('Update',['class'=>'btn btn btn-primary','value'=>'true'])!!}
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
