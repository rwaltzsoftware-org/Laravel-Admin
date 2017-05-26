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
      <i class="fa fa-home">
      </i>
      <a href="{{ url($admin_panel_slug.'/dashboard') }}" class="call_loader"> {{translation("dashboard")}}
      </a>
    </li>
    <span class="divider">
      <i class="fa fa-angle-right">
      </i>
      <i class="fa {{$module_icon or ''}}">
      </i>
      <a href="{{ url($module_url_path) }}" class="call_loader"> {{ $module_title or ''}}
      </a>
    </span>
  </ul>
</div>
<!-- END Breadcrumb -->
<!-- BEGIN Main Content -->
<div class="row">
  <div class="col-md-12">
    <div class="box ">
      <div class="box-title">
        <h3>
          <i class="fa {{$module_icon or ''}}">
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
      
      
      <div class="box-content studt-padding">
        


        @include('admin.layout._operation_status') 


        <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url($module_url_path.'/multi_action') }}">
          {{ csrf_field() }}
          
          <div class="btn-toolbar pull-right clearfix">
            <div class="btn-group">
              <!-- 
              <a href="{{ url($module_url_path.'/create') }}" class="btn btn-primary btn-add-new-records" title="Add New Category/Sub Category">Add New Category/Sub Category
              </a>  -->
            </div>
            <div class="btn-group"> 
              <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip call_loader" 
                 title="{{translation("refresh")}}" 
                 href="javascript:void(0)"
                 onclick="javascript:location.reload();" 
                 style="text-decoration:none;">
                <i class="fa fa-repeat">
                </i>
              </a> 
            </div>
          </div>
          <br/>
          <br/>
          <br/>
          <div class="clearfix">
          </div>
           <div class="row">
                  <div class="block-new-block">
                  <div class="col-sm-4 col-lg-2 controls">
                  </div>
                  <div class="col-sm-4 col-lg-2 controls">
                  </div>
                  <div class="col-sm-4 col-lg-2 controls">
                  </div>
                  <div class="col-sm-4 col-lg-2 controls">
                  </div>
                  <div class="col-sm-4 col-lg-2 controls">
                    
                  </div>
                  <div class="col-sm-4 col-lg-2 controls">
                    
                  </div>
                    <div class="clearfix"></div>
                  </div>
                </div>
          <div class="border-box">   
          <div class="table-responsive" style="border:0">
            <input type="hidden" name="multi_action" value="" />
            <table class="table table-advance"   id="table_module">
              <thead>
                <tr>
                    <th>
                      <a class="sort-desc sort-asc" href="#"> Date </a>
                      <input id="date" name="q_date" onchange="filterData();" onkeypress="javascript:return false;" Placeholder="Select Date" value="" class="search-block-new-table column_filter" type="text" >
                    </th>
                    <th>
                      <a class="sort-desc sort-asc " href="#"> Module Name </a>
                      <input type="text" name="q_module_name" id="q_module_name" placeholder="Search" class="search-block-new-table column_filter" />
                    </th>
                    <th>
                      <a class="sort-desc sort-asc" href="#"> User Name </a>
                      <input type="text" name="q_user_name" placeholder="Search" class="search-block-new-table column_filter" />
                    </th>
                    <th><a class="sort-desc sort-asc" href="#"> Action Performed </a>
                      <select name="q_action" id="q_action" onchange="filterData();" class="form-control column_filter">
                          <option value="">Select Action Performed
                          </option>
                          <option value="ADD">Add
                          </option>
                          <option value="EDIT">Edit
                          </option>
                          <option value="REMOVED">Removed
                          </option>
                      </select>
                    </th>
                </tr>
              </thead>
           </table>
        </div>
     
    </div>
  </form>
</div>
</div>
</div>
<!-- END Main Content -->
<script type="text/javascript">
  
  $('#date').datepicker({ 
  dateFormat: "yy-mm-dd"
  });
  
  function show_details(url)
  {
    window.location.href = url;
  }

  var table_module = false;
 $(document).ready(function()
  {
    table_module = $('#table_module').DataTable({ 
      processing: true,
      serverSide: true,
      autoWidth: false,
      bFilter: false ,
      ajax: {
      'url':'{{ $module_url_path.'/get_records'}}',
      'data': function(d)
        {
          d['column_filter[q_date]']        = $("input[name='q_date']").val()
          d['column_filter[q_module_name]'] = $("input[name='q_module_name']").val()
          d['column_filter[q_action]']      = $("select[name='q_action']").val()
          d['column_filter[q_user_name]']   = $("input[name='q_user_name']").val()
          
        }
      },
      columns: [
      /*{
        render : function(data, type, row, meta) 
        {
        return '<input type="checkbox" '+
        ' name="checked_record[]" '+  
        ' value="'+row.enc_id+'"/>';
        },
        "orderable": false,
        "searchable":false
      },*/
      {data: 'date', "orderable": true, "searchable":false},
      {data: 'module_name', "orderable": true, "searchable":false},
      {data: 'user_name', "orderable": true, "searchable":false},
      
      {data: 'action', "orderable": false, "searchable":false},
      ]
    });
    

    $('input.column_filter').on( 'keyup click', function () 
    {
        filterData();
    });


    $('#table_module').on('draw.dt',function(event)
    {
      var oTable = $('#table_module').dataTable();
      var recordLength = oTable.fnGetData().length;
      $('#record_count').html(recordLength);
    });
  });

  function confirm_delete()
  {
    if(confirm('Are you sure to delete this record?'))
    {
      return true;
    }
    return false;
  }
  function check_multi_action(checked_record,frm_id,action)
  {
    var checked_record = document.getElementsByName(checked_record);
    var len = checked_record.length;
    var flag=1;
    var input_multi_action = jQuery('input[name="multi_action"]');
    var frm_ref = jQuery("#"+frm_id);
    if(len<=0)
    {
      alert("No records to perform this action");
      return false;
    }
    if(confirm('Do you really want to perform this action'))
    {
      for(var i=0;i<len;i++)
      {
        if(checked_record[i].checked==true)
        {
          flag=0;
          /* Set Action in hidden input*/
          jQuery('input[name="multi_action"]').val(action);
          /*Submit the referenced form */
          jQuery(frm_ref)[0].submit();
        }
      }
      if(flag==1)
      {
        alert('Please select record(s)');
        return false;
      }
    }
  }

  function filterData()
  {
    table_module.draw();
  }

  /*function ratingsfilter(ref)
  {
      $('#frm_star_filter').submit();
  }*/
</script>
  @stop                    
