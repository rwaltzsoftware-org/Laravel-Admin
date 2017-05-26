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
                <i class="fa fa-user-secret"></i>
                <a href="{{ $module_url_path }}">{{ $module_title or ''}}</a>
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



            <div class="form-group">
                  <label class="col-sm-3 col-lg-2 control-label">First Name<i class="red">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" data-rule-required="true" data-rule-maxlength="255" />
                      <span class="help-block">{{ $errors->first('first_name') }}</span>
                  </div>
            </div>

            <div class="form-group">
                  <label class="col-sm-3 col-lg-2 control-label">Last Name<i class="red">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" data-rule-required="true" data-rule-maxlength="255" />
                      <span class="help-block">{{ $errors->first('last_name') }}</span>
                  </div>
            </div>

            <div class="form-group">
                  <label class="col-sm-3 col-lg-2 control-label">Email<i class="red">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      <input type="text" class="form-control" name="email" value="{{ old('email') }}" data-rule-required="true" data-rule-email="true" data-rule-maxlength="255" />
                      <span class="help-block">{{ $errors->first('email') }}</span>
                  </div>
            </div>

            <div class="form-group">
                  <label class="col-sm-3 col-lg-2 control-label">Password<i class="red">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      <input type="password" class="form-control" name="password" value="{{ old('password') }}" data-rule-required="true" data-rule-minlength="6" data-rule-maxlength="255" id="password"/>
                      <span class="help-block">{{ $errors->first('password') }}</span>
                  </div>
            </div>

            <div class="form-group">
                  <label class="col-sm-3 col-lg-2 control-label">Confirm Password<i class="red">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                      <input type="password" class="form-control" name="password_confirmation" value="{{ old('password') }}" data-rule-required="true" data-rule-equalto="#password" data-rule-minlength="6" data-rule-maxlength="255"/>
                      <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                  </div>
            </div>

            <div class="form-group">
                  <label class="col-sm-3 col-lg-2 control-label">Roles<i class="red">*</i></label>
                  <div class="col-sm-9 col-lg-4 controls" >
                    <select class="form-control" name="roles[]" data-rule-required="true">
                      <option value="">-</option>
                       @if(isset($arr_roles) && sizeof($arr_roles)>0)
                        @foreach($arr_roles as $role)
                         @if($role['slug']=='admin')
                              <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                          @endif
                        @endforeach
                        @endif
                    </select>
                      <span class="help-block">{{ $errors->first('roles') }}</span>
                  </div>


            </div>

            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" value="Add">
            </div>
        </div>
    </form>
</div>
</div>
</div>

<!-- END Main Content -->
 
@stop                    