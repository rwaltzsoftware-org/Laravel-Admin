    @extends('admin.layout.master')                


    @section('main_content')
    <!-- BEGIN Page Title -->

    {{-- <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/data-tables/latest/dataTables.bootstrap.min.css"> --}}
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
                <i class="fa fa-question-circle"></i>
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

          <div class="box">
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
          <a href="{{ $module_url_path.'/create' }}" class="btn btn-primary btn-add-new-records" title="Add New Property Type">Add FAQ</a> 
          </div>
  
      
            <div class="btn-group"> 
                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip" 
                   title="Lock" 
                   href="javascript:void(0)"
                   onclick="javascript : return check_multi_action('checked_record[]','frm_manage','deactivate');" 
                   style="text-decoration:none;">
                   <i class="fa fa-lock"></i>
                </a> 

                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip" 
                   title="Unlock" 
                   href="javascript:void(0)"
                   onclick="javascript : return check_multi_action('checked_record[]','frm_manage','activate');" 
                   style="text-decoration:none;">
                   <i class="fa fa-unlock"></i>
                </a> 

                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip" 
                   title="Multiple Delete" 
                   href="javascript:void(0);" 
                   onclick="javascript : return check_multi_action('checked_record[]','frm_manage','delete');"  
                   style="text-decoration:none;">
                   <i class="fa fa-trash-o"></i>
                </a>

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

            <table class="table table-advance"  id="table_module" >
              <thead>
                <tr>
                  <th style="width:18px"> <input type="checkbox" name="mult_change" id="mult_change" /></th>
                  <th>Question</th> 
                  <th>Answer</th>
                  <th>Status</th> 
                  <th style="text-align:center;">Translations</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
          
                @if(sizeof($arr_data)>0)
                  @foreach($arr_data as $data)
                  <tr>
                    <td> 
                      <input type="checkbox" 
                             name="checked_record[]"  
                             value="{{ base64_encode($data['id']) }}" /> 
                    </td>
                    <td > {{ $data['question'] }} </td> 
                    <td>  {!! $data['answer'] !!} </td>
                    
                    <td>
                      @if($data['is_active']==1)
                        <a href="{{ $module_url_path.'/deactivate/'.base64_encode($data['id']) }}" class="btn btn-sm btn-success show-tooltip"  onclick="return confirm('Are you sure to Deactivate this record?')"><i class='fa fa-unlock'></i></a>
                      @else
                        <a href="{{ $module_url_path.'/activate/'.base64_encode($data['id']) }}" class="btn btn-sm btn-danger show-tooltip" onclick="return confirm('Are you sure to Activate this record?')"><i class='fa fa-lock'></i></a>
                      @endif
                     
                    </td> 

                    <!-- Translations  -->
                    <td style="text-align:center;">

                       <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#see_avail_translation_{{ $data['id']}}"  title="View Translations">View</button>

                        <!-- Modal -->
                        <div id="see_avail_translation_{{ $data['id']}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-sm">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Translation Available In</h4>
                              </div>
                              <div class="modal-body">
                                   @if(isset($data['arr_translation_status']) && sizeof($data['arr_translation_status'])>0)
                                    <ul style="list-style-type: none;">
                                      @foreach($data['arr_translation_status'] as $translation_status)
                                        @if($translation_status['is_avail']==1)
                                          <li>
                                            <h5>
                                              <i class="fa fa-check text-success"></i>
                                              {{ $translation_status['title'] }}
                                            </h5>
                                          </li>
                                        @else
                                          <li>
                                            <h5>
                                              <i class="fa fa-times text-danger"></i> 
                                              {{ $translation_status['title'] }}
                                            </h5>  
                                          </li>
                                        @endif       
                                      @endforeach
                                    </ul>
                                   @endif
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </td>

                    <td> 
                        <a href="{{ $module_url_path.'/edit/'.base64_encode($data['id']) }}" title="Edit">
                          <i class="fa fa-edit" ></i>
                        </a>  
                     
                        &nbsp;  
                        <a href="{{ $module_url_path.'/delete/'.base64_encode($data['id']) }}"  
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
          </div>
        <div> </div>
         
          {!! Form::close() !!}
      </div>
  </div>
</div>

<!-- END Main Content -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#table_module').DataTable( {
            "aoColumns": [
            { "bSortable": false },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": false }
            ]

        });
    });

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
</script>
 <!--page specific plugin scripts-->
        {{-- <script type="text/javascript" src="{{ url('/') }}/assets/data-tables/latest/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/data-tables/latest/dataTables.bootstrap.min.js"></script> --}}
@stop                    


