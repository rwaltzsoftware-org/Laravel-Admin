<?php 

namespace App\Common\Traits;

use Illuminate\Http\Request;
use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use Flash;
use Validator;
 
trait MultiActionTrait
{
    public function multi_action(Request $request)
    {
        $arr_rules = array();
        $arr_rules['multi_action'] = "required";
        $arr_rules['checked_record'] = "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Flash::error('Please Select '.$this->module_title.' To Perform Multi Actions');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Flash::error('Problem Occurred, While Doing Multi Action');
            return redirect()->back();
        }

        foreach ($checked_record as $key => $record_id) 
        {  
            if($multi_action=="delete")
            {
               $this->perform_delete(base64_decode($record_id));    
               Flash::success($this->module_title.' Deleted Successfully'); 
            } 
            elseif($multi_action=="activate")
            {
               $this->perform_activate(base64_decode($record_id)); 
               Flash::success($this->module_title.' Activated Successfully'); 
            }
            elseif($multi_action=="deactivate")
            {
               $this->perform_deactivate(base64_decode($record_id));    
               Flash::success($this->module_title.' Blocked Successfully');  
            }
        }

        return redirect()->back();
    }

    public function activate($enc_id = FALSE)
    {
        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_activate(base64_decode($enc_id)))
        {
            Flash::success($this->module_title. ' Activated Successfully');
        }
        else
        {
            Flash::error('Problem Occured While '.$this->module_title.' Activation ');
        }

        return redirect()->back();
    }

    public function deactivate($enc_id = FALSE)
    {
        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_deactivate(base64_decode($enc_id)))
        {
            Flash::success($this->module_title. ' Deactivated Successfully');
        }
        else
        {
            Flash::error('Problem Occured While '. $this->module_title .' Deactivation ');
        }

        return redirect()->back();
    }

    public function delete($enc_id = FALSE)
    {
        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_delete(base64_decode($enc_id)))
        {
            Flash::success($this->module_title.' Deleted Successfully');
        }
        else
        {
            Flash::error('Problem Occured While '.$this->module_title.' Deletion ');
        }

        return redirect()->back();
    }


    public function perform_activate($id)
    {
        $static_page = $this->BaseModel->where('id',$id)->first();
        
        if($static_page)
        {

            return $static_page->update(['is_active'=>1]);
        }

        return FALSE;
    }

    public function perform_deactivate($id)
    {
        $static_page = $this->BaseModel->where('id',$id)->first();
        
        if($static_page)
        {
            return $static_page->update(['is_active'=>0]);
        }

        return FALSE;
    }

    public function perform_delete($id)
    {
        $delete= $this->BaseModel->where('id',$id)->delete();
        
        if($delete)
        {
            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
                $arr_event                 = [];
                $arr_event['ACTION']       = 'REMOVED';
                $arr_event['MODULE_TITLE'] = $this->module_title;

                $this->save_activity($arr_event);
            /*----------------------------------------------------------------------*/
            return TRUE;
        }

        return FALSE;
    }
   
}