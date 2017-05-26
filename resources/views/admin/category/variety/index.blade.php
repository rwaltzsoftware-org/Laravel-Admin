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
      <a class=" call_loader" href="{{ $module_url_path_dashbord }}">Dashboard
      </a>
    </li>
    <span class="divider">
      <i class="fa fa-angle-right">
      </i>
      <i class="fa fa-envira">
      </i>
      <a class=" call_loader" href="{{ $module_url_path_categories }}">Category
      </a>
    </span>
    <span class="divider">
      <i class="fa fa-angle-right">
      </i>
      <i class="fa fa-tags">
      </i>
      <a class=" call_loader" href="{{ $module_url_path_sub_category."/".base64_encode($category_id) }}">Sub-Category
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
<div class="row">
  <div class="col-md-12">
    <div class="box box-navi_blue">
      <div class="box-title">
        <h3>
          <i class="fa fa-list">
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
        <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url($module_url_path.'/multi_action') }}">
          {{ csrf_field() }}
          <div class="col-md-10">
            <div id="ajax_op_status">
            </div>
            <div class="alert alert-danger" id="no_select" style="display:none;">
            </div>
            <div class="alert alert-warning" id="warning_msg" style="display:none;">
            </div>
          </div>
          <div class="btn-toolbar pull-right clearfix">
            <div class="btn-group">

              <a href="{{ $module_url_path.'/create/'.base64_encode($sub_category_id) }}" class="btn btn-primary btn-add-new-records" title="Add New Variety">Add New Variety
              </a> 
            </div>
            <div class="btn-group">
              <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip" 
                 title="Multiple Active/Unblock" 
                 href="javascript:void(0);" 
                 onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" 
                 style="text-decoration:none;">
                <i class="fa fa-unlock">
                </i>
              </a> 
            </div>
            <div class="btn-group">
              <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip" 
                 title="Multiple Deactive/Block" 
                 href="javascript:void(0);" 
                 onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');"  
                 style="text-decoration:none;">
                <i class="fa fa-lock">
                </i>
              </a> 
            </div>
            <div class="btn-group">
              <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip" 
                 title="Multiple Delete" 
                 href="javascript:void(0);" 
                 onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');"  
                 style="text-decoration:none;">
                <i class="fa fa-trash-o">
                </i>
              </a>
            </div>  
            <div class="btn-group"> 
              <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip call_loader" 
                 title="Refresh" 
                 href="javascript:void(0)"
                 onclick="javascript:location.reload();" 
                 style="text-decoration:none;">
                <i class="fa fa-repeat">
                </i>
              </a> 
            </div>
          </div>
          <br/>
          <div class="clearfix">
          </div>
          <div class="table-responsive" style="border:0">
            <input type="hidden" name="multi_action" value="" />
            <table class="table table-advance"  id="table1" >
              <thead>
                <tr>
                  <th style="width:18px"> 
                    <input type="checkbox" name="mult_change" id="mult_change" />
                  </th>
                  <th>Variety
                  </th>
                  <th>Sub-Category
                  </th> 
                  <th>Category
                  </th> 
                  <th>Status
                  </th> 
                  <th>Action
                  </th>
                </tr>
              </thead>
              <tbody>
                @if(sizeof($arr_variety)>0)
                @foreach($arr_variety as $variety)
                <tr>
                  <td> 
                    <input type="checkbox" 
                           name="checked_record[]"  
                           value="{{ base64_encode($variety['id']) }}" /> 
                  </td>
                  <td>
                    {{ $variety['name'] or 'NA' }}
                  </td>
                  <td>
                    {{ $variety['child_category']['category_title'] or 'NA' }}
                  </td>
                  <td > {{ $variety['parent_category']['category_title'] or 'NA' }} 
                  </td>
                  <td>
                    @if($variety['is_active']==1)
                    <a href="{{ $module_url_path.'/deactivate/'.base64_encode($variety['id']) }}" onclick="return confirm_action(this,event);" class="btn btn-success">
                      <i class='fa fa-unlock'>
                      </i>
                    </a>
                    @else
                    <a href="{{ $module_url_path.'/activate/'.base64_encode($variety['id']) }}" onclick="return confirm_action(this,event);" class="btn btn-danger">
                      <i class='fa fa-lock'>
                      </i>
                    </a>
                    @endif                     
                  </td>
                  <td> 
                    <a href="{{ url($module_url_path.'/edit/'.base64_encode($variety['id'])) }}" title="Edit">
                      <i class="fa fa-edit" >
                      </i>
                    </a>  
                    &nbsp;  
                    <a href="{{ url($module_url_path.'/delete/'.base64_encode($variety['id'])) }}"  
                       onclick="return confirm_action(this,event);"
                       title="Delete">
                      <i class="fa fa-trash" >
                      </i>  
                    </a>  
                  </td>
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>
          </div>
          <div> 
          </div>
        </form>
      </div>
    </div>
  </div>

<!-- END Main Content -->
@include('admin.layout._aleart_msg')
<script type="text/javascript">
  function show_details(url)
  {
    window.location.href = url;
  }
</script>
<!--page specific plugin scripts-->
<script type="text/javascript" src="{{ url('/') }}/assets/data-tables/latest/jquery.dataTables.min.js">
</script>
<script type="text/javascript" src="{{ url('/') }}/assets/data-tables/latest/dataTables.bootstrap.min.js">
</script>
@stop                    
