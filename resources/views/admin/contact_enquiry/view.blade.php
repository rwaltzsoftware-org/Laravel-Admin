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
            <li>
                <i class="fa fa-angle-right"></i>
                <i class="fa fa-info-circle"></i>
                <a href="{{ $module_url_path }}">{{ $module_title or ''}}</a>
            </li>  
            <span class="divider">
                <i class="fa fa-angle-right"></i>
                <i class="fa fa-eye"></i>
            </span>
            <li class="active"> {{ $page_title or ''}}</li>
        </ul>
      </div>
      <!-- END Breadcrumb -->

 
        <!-- START Main Content -->


          <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="fa fa-eye"></i>{{ isset($page_title)?$page_title:"" }}</h3>
                        <div class="box-tool">
                          
                        </div>
                    </div>
                    <div class="box-content">

                        <div class="row">
                         <div class="col-md-12"> 
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>

                                        <span 
                                                class="text-" 
                                              ondblclick="scrollToButtom()"
                                              style="cursor: default;" 
                                              title="Double click to Take Action" 
                                              >
                                            
                                        </span>
                                        
                                    </h3>
                                </div>
                                <div class="col-md-6">
                                    
                                </div>
                            </div>


                     {!! Form::open([ 
                                 'method'=>'POST',
                                 'enctype' =>'multipart/form-data',   
                                 'class'=>'form-horizontal', 
                                 'id'=>'validation-form' 
                                ]) !!} 

                            
                           <div class="form-group"> 
                            <label class="col-sm-3 col-lg-2 control-label" ></label>
                              <div class="col-sm-3 col-lg-3 controls">
                                  <h4><b>Enquiry Details:</b></h4>
                              </div>
                          </div> 
                        

                            <div class="form-group">
                                <label class="col-sm-3 col-lg-2 control-label" for="email_id">User Name</label>
                                <div class="col-sm-6 col-lg-4 controls">
                                    <input class="form-control" name="" id=""  value="{{ isset($arr_contact_enquiry['user_name']) && $arr_contact_enquiry['user_name'] !=""  ?$arr_contact_enquiry['user_name']:'NA' }}" readonly="" style="background-color : white"/>
                                </div>
                            </div>


                             <div class="form-group">
                                <label class="col-sm-3 col-lg-2 control-label" for="email_id">User Email</label>
                                <div class="col-sm-6 col-lg-4 controls">
                                    <input class="form-control" name="" id=""  value="{{ isset($arr_contact_enquiry['email']) && $arr_contact_enquiry['email'] !=""  ?$arr_contact_enquiry['email']:'NA' }}" readonly="" style="background-color : white" />
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-sm-3 col-lg-2 control-label" for="email_id">Contact</label>
                                <div class="col-sm-6 col-lg-4 controls">
                                    <input class="form-control" name="" id=""  value="{{ isset($arr_contact_enquiry['phone']) && $arr_contact_enquiry['phone'] !=""  ?$arr_contact_enquiry['phone']:'NA' }}" readonly="" style="background-color : white" />
                                </div>
                            </div>
                             
                             
                             
                             <div class="form-group">
                                <label class="col-sm-3 col-lg-2 control-label" for="email_id">Subject</label>
                                <div class="col-sm-6 col-lg-4 controls">
                                    <input class="form-control" name="" id=""  value="{{ isset($arr_contact_enquiry['subject']) && $arr_contact_enquiry['subject'] !=""  ?$arr_contact_enquiry['subject']:'NA' }}" readonly="" style="background-color : white" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 col-lg-2 control-label" for="message">Message</label>
                                <div class="col-sm-6 col-lg-4 controls">
                                    <textarea class="form-control" name="message" id="message" readonly="" style="background-color : white" >{{ isset($arr_contact_enquiry['comments']) && $arr_contact_enquiry['comments'] !=""  ?$arr_contact_enquiry['comments']:'NA' }}</textarea>
                                    
                                    <span class='help-block'>{{ $errors->first('message') }}</span>
                                </div>
                            </div>


                            <div class="form-group">
                              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                              <a href="{{ $module_url_path }}"> 
                                <input type="button"  class="btn btn-primary" value="Back">
                              </a>  
                            </div>
                            </div>
                  
                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- END Main Content -->
<script type="text/javascript">
    function scrollToButtom()
    {
        $("html, body").animate({ scrollTop: $(document).height() }, 1000);
    }

    $(document).ready(function()
    {
        $("#select_action").bind('change',function()
        {
            if($(this).val()=="cancel")
            {
                $("#reason_section").show();
            }
            else
            {
                $("#reason_section").hide();
            }
        });
    });
</script>

  @stop                    


