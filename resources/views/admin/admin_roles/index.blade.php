    @extends('admin.layout.master')                


    @section('main_content')
    <!-- BEGIN Page Title -->

    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/data-tables/latest/dataTables.bootstrap.min.css">
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
                <i class="fa fa-users"></i>
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
                <i class="fa fa-list"></i>
                {{ isset($page_title)?$page_title:"" }}
            </h3>
            <div class="box-tool">
                <a data-action="collapse" href="#"></a>
                <a data-action="close" href="#"></a>
            </div>
        </div>
        <div class="box-content">
        
          
        @include('admin.layout._operation_status')  

          {!! Form::open([ 'url' => $module_url_path.'/multi_action',
                                 'method'=>'POST',
                                 'enctype' =>'multipart/form-data',   
                                 'class'=>'form-horizontal', 
                                 'id'=>'frm_manage' 
                                ]) !!} 

            {{ csrf_field() }}

            <div class="col-md-10">
            

            <div id="ajax_op_status">
                
            </div>
            <div class="alert alert-danger" id="no_select" style="display:none;"></div>
            <div class="alert alert-warning" id="warning_msg" style="display:none;"></div>
          </div>
          <div class="btn-toolbar pull-right clearfix">

          
          <div class="btn-group">
          <a href="{{ $module_url_path.'/create' }}" class="btn btn-primary btn-add-new-records" title="Add Admin Roles">Add Admin Roles</a> 
          </div>
  
      
            <div class="btn-group"> 
                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip" 
                   title="Refresh" 
                   href="javascript:void(0)"
                   onclick="javascript:location.reload();" 
                   style="text-decoration:none;">
                   <i class="fa fa-repeat"></i>
                </a> 
            </div>
          </div>
          <br/>
          <div class="clearfix"></div>
          <div class="table-responsive" style="border:0">

            <input type="hidden" name="multi_action" value="" />

            <table class="table table-advance"  id="table1" >
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Role</th>
                  <th>Slug</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                 @if(sizeof($arr_roles)>0)
                  @foreach($arr_roles as $role)
                  <tr>
                    <td>
                        {{ $role['id']}}
                    </td> 
                    <td >
                        {{ $role['name']}}
                    </td> 
                    <td >
                        {{ $role['slug']}}
                    </td> 
                    <td> 
                      @if(!in_array($role['slug'],["user","admin"]))
                        <a href="{{ $module_url_path.'/edit/'.base64_encode($role['id']) }}">
                          <i class="fa fa-edit" title="Edit"  ></i>
                        </a>  
                     
                        &nbsp;  
                       <a href="{{ $module_url_path.'/delete/'.base64_encode($role['id']) }}"  
                          onclick="return confirm_delete();" 
                          title="Delete">
                            <i class="fa fa-trash" title="Delete" ></i>  
                        </a>
                      @else
                        <span class="text-danger">No Action Available</span>  
                      @endif  
                    </td>
                  </tr>
                  @endforeach
                @endif
                 
              </tbody>
            </table>
          </div>
        
         {!! Form::close() !!}
      </div>
  </div>
</div>

<!-- END Main Content -->
<script type="text/javascript">
    function show_details(url)
    { 
       
        window.location.href = url;
    } 

    
    function confirm_delete()
    {
       if(confirm('Are you sure to delete this record?'))
       {
        return true;
       }
       return false;
    }

    
</script>

@stop                    


