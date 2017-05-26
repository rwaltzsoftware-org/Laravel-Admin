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
      <a href="{{ url($admin_panel_slug.'/dashboard') }}" class="call_loader">Dashboard
      </a>
    </li>
    <span class="divider">
      <i class="fa fa-angle-right">
      </i>
      <i class="fa {{$module_icon or ''}}">
      </i>
      <a href="{{ url($module_url_path) }}" class="call_loader">{{ $module_title or ''}}
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
    <div class="box ">
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
      
      
      <div class="box-content studt-padding">
        
        @include('admin.layout._operation_status') 

        <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url($module_url_path.'/multi_action') }}">
          {{ csrf_field() }}
          
          <div class="btn-toolbar pull-right clearfix">
                        
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
          <br/>
          <div class="clearfix">
          </div>
           <div class="row">
                  <div class="block-new-block">
                 
                 
                  <!--<div class="col-sm-4 col-lg-3 controls">
                    <a href="{{ url($module_url_path.'/create') }}" title="Add {{ $module_title or ''}}">
                      <button type="button" class="btn btn-success">
                          <i class="fa fa-plus" aria-hidden="true"></i> 
                             Add {{ $module_title or ''}}
                      </button>
                    </a>
                  </div>-->
                    <div class="clearfix"></div>
                  </div>
                </div>
                <div class="table-responsive" style="border:0">
                  
                  <table class="table table-advance"   id="table_module">
                    <thead>
                      <tr>                          
                          <th><a class="sort-desc sort-active" href="#">Keyword </a>
                              <input type="text" name="q_keyword" placeholder="Search" class="search-block-new-table column_filter" />
                          </th>
                          <th><a class="sort-asc" href="#">Title</a>
                              <input type="text" name="q_title" placeholder="Search" class="search-block-new-table column_filter" />
                          </th>
                          <th><a class="sort-desc" href="#">Locale</a>
                                @if(isset($arr_lang) && sizeof($arr_lang) > 0)
                                  <select name="q_locale" class="search-block-new-table column_filter"> 
                                  <option value="">Select</option>
                                  @foreach($arr_lang as $lang)
                                    <option value="{{isset($lang['locale']) ? $lang['locale'] : ''}}">{{isset($lang['title']) ? $lang['title'] : ''}}  </option>
                                  @endforeach
                                  </select>
                                @endif
                                
                          </th>
                          
                          <th><a class="sort-desc sort-asc" href="#">Action</a></th>
                      </tr>
                    </thead>
                 </table>
              </div>
      <div> 
    </div>
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

          d['column_filter[q_keyword]']        = $("input[name='q_keyword']").val()
          d['column_filter[q_title]']          = $("input[name='q_title']").val()
          d['column_filter[q_locale]']         = $("select[name='q_locale']").val()         
        }
      },
      columns: [
      
      
      {data: 'keyword', "orderable": true, "searchable":false},
      {data: 'title', "orderable": true, "searchable":false},
      {data: 'locale', "orderable": false, "searchable":false},      
      
      
      {
        render : function(data, type, row, meta) 
        {
          return '<a class="btn btn-primary btn-sm show-tooltip call_loader" href="'+row.built_edit_href+'" title="Edit"><i class="fa fa-edit" ></i></a>&nbsp;';
        },
        "orderable": false, "searchable":false
      }]
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
