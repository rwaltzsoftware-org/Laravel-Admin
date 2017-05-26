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
                <i class="fa fa-list-alt"></i>
                <a href="{{ url($module_url_path) }}">{{ $module_title or ''}}</a>
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

          <div class="box ">
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
          
          <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url($module_url_path.'/multi_action') }}">

            {{ csrf_field() }}

            <div class="col-md-10">
            

            <div id="ajax_op_status">
                
            </div>
            <div class="alert alert-danger" id="no_select" style="display:none;"></div>
            <div class="alert alert-warning" id="warning_msg" style="display:none;"></div>
          </div>
          <div class="btn-toolbar pull-right clearfix">

          
          <div class="btn-group">
          <a href="{{ url($module_url_path.'/create') }}" class="btn btn-primary btn-add-new-records" title="Add New Category/Sub Category">Add New Category/Sub Category</a> 
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
                <table class="table table-advance"  id="table_module">
                  <thead>
                    <tr>                          
                        <th style="width: 18px; vertical-align: initial;"><input type="checkbox"/></th>
                        <th><a class="sort-desc" href="#">Category </a>
                            <input type="text" name="q_category" placeholder="Search" class="search-block-new-table column_filter" />
                        </th>
                        <th><a class="sort-asc" href="#">Sub Category</a>
                        </th>
                        <th><a class="sort-asc" href="#">Status</a>
                        </th>
                        <th><a class="sort-desc " href="#">Action</a></th>
                    </tr>
                  </thead>
               </table>
            </div>

          {{-- <div class="table-responsive" style="border:0">

            <input type="hidden" name="multi_action" value="" />

            <table class="table table-advance"  id="table1" >
              <thead>
                <tr>
                  <th style="width:18px"> <input type="checkbox" name="mult_change" id="mult_change" /></th>
                  <th>Category</th> 
                  <th>Sub Category</th> 
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
          
                @if(sizeof($arr_category)>0)
                  @foreach($arr_category as $category)
              
                  
                  <tr>
                    <td> 
                      <input type="checkbox" 
                             name="checked_record[]"  
                             value="{{ base64_encode($category['id']) }}" /> 
                    </td>
                    <td > {{ $category['category_title'] }} </td> 
                    
                    <td>
                        <a href="{{ url($module_url_path.'/sub_categories/'.base64_encode($category['id'])) }}" class="btn btn-success" title="View Sub Categories">View </a>
                    </td>
                    <td>
                  @if($category['is_active']==1)
                     <a href="{{ $module_url_path.'/deactivate/'.base64_encode($category['id']) }}" onclick="return confirm('Are you sure to Deactivate this record?')" class="btn btn-sm btn-success show-tooltip" title="Active" style="color:#fff;"><i class='fa fa-unlock'></i>
                      </a>   
                   
                   @else
                    
                    <a href="{{ $module_url_path.'/activate/'.base64_encode($category['id']) }}" onclick="return confirm('Are you sure to Activate this record?')" class="btn btn-sm btn-danger show-tooltip" title="Inactive" style="color:#fff;"> <i class='fa fa-lock'></i>
                     
                    </a> 
                    
                   @endif

                </td>
                    <td> 
                        <a href="{{ url($module_url_path.'/edit/'.base64_encode($category['id'])) }}" title="Edit">
                          <i class="fa fa-edit" ></i>
                        </a>  
                     
                        &nbsp;  
                        <a href="{{ url($module_url_path.'/delete/'.base64_encode($category['id'])) }}"  
                           onclick="return confirm_delete();" 
                           title="Delete">
                          <i class="fa fa-trash" ></i>  
                        </a>  
                    </td>
                  </tr>
                  @endforeach
                @endif
                 
              </tbody>
            </table>
          </div> --}}


        <div> </div>
         
          </form>
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


  /*Script to show table data*/

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
          d['column_filter[q_category]']        = $("input[name='q_category']").val()
        }
      },
      columns: [
      {
        render : function(data, type, row, meta) 
        {
        return '<input type="checkbox" '+
        ' name="checked_record[]" '+  
        ' value="'+row.enc_id+'"/>';
        },
        "orderable": false,
        "searchable":false
      },
      {data: 'category_title', "orderable": true, "searchable":false},
      {
        render : function(data, type, row, meta) 
        {
          return row.build_view_sub_category;
        },
        "orderable": false, "searchable":false
      },
      {
        render : function(data, type, row, meta) 
        {
          return row.build_status_btn;
        },
        "orderable": false, "searchable":false
      },
      {
        render : function(data, type, row, meta) 
        {
          return row.build_action_btn;
        },
        "orderable": false, "searchable":false
      }
      ]
    });

    $('input.column_filter').on( 'keyup click', function () 
    {
        filterData();
    });

    $('select.column_filter').on( 'keyup click', function () 
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

  

  function filterData()
  {
    table_module.draw();
  }

  
</script>
 
@stop                    


