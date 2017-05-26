<?php 
namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\StateModel; 
use App\Models\DistrictModel;
use App\Models\TalukaModel;
use App\Models\CategoryModel; 
use App\Models\VarietyModel; 
use App\Models\UnitModel;
use Validator;
use Session;
use Input;
use Auth;
 
class LocationController extends Controller
{

  /*
    | Constructor : creates instances of model class 
    |               & handles the admin authantication
    | auther : MOHAN SONAR 
    | Date : 04-05-2016
    | @return \Illuminate\Http\Response
    */

    public function __construct()
    {
        $this->locale = \App::getLocale(); 
        $this->record_lang = "1";  // English Default 

        if($this->locale=="en")
        {
            $this->record_lang = "1"; // English 
        }
        else if($this->locale=="de")
        {
           
            $this->record_lang = "2"; // German 
        }
    }


      /*
    | get_states : function to generate States belongs 
    |              to specific country
    | auther : MOHAN SONAR 
    | Date : 02/02/2016
    | @param :  int $country_id
    | @return \Illuminate\Http\Response
    */

    public function get_states($country_id)
    {
        $arr_state = array();
        $arr_response = array();

        $obj_states = StateModel::select('id','country_id')
                                       ->where('country_id',$country_id)
                                       ->get();

        if($obj_states != FALSE)
        {
            $arr_state =  $obj_states->toArray();
        }
        if(sizeof($arr_state)>0)
        {
            $arr_response['status']    = "SUCCESS";
            $arr_response['arr_state'] = $arr_state;
        }
        else
        {
            $arr_response['status']    = "ERROR";
            $arr_response['arr_state'] = array();
        }
        return response()->json($arr_response);
    }

    public function get_districts($state_id)
    {
        $arr_state = array();
        $arr_response = array();

        $obj_cities = DistrictModel::select('id','state_id')
                                       ->where('state_id',$state_id)
                                       ->get();

        if($obj_cities != FALSE)
        {
            $arr_district =  $obj_cities->toArray();
        } 

        if(sizeof($arr_district)>0)
        {
            $arr_response['status'] ="SUCCESS";    
            $arr_response['arr_district'] = $arr_district;    
        }
        else
        {
            $arr_response['status'] ="ERROR";    
            $arr_response['arr_district'] = array();       
        }
        return response()->json($arr_response);   
    }


    public function get_taluka($district_id)
    {
        $arr_state    = array();
        $arr_response = array();

        $obj_taluka = TalukaModel::select('id','district_id')
                                ->where('district_id',$district_id)
                                ->get();

        if($obj_taluka != FALSE)
        {
            $arr_taluka =  $obj_taluka->toArray();
        }

        if(sizeof($arr_taluka)>0)
        {
            $arr_response['status'] ="SUCCESS";    
            $arr_response['arr_taluka'] = $arr_taluka;    
        }
        else
        {
            $arr_response['status'] ="ERROR";    
            $arr_response['arr_taluka'] = array();       
        }
        
        return response()->json($arr_response);  
    } 


    public function get_sub_category($category_id)
    {
        $arr_sub_category = array();
        $arr_units        = array();
        $arr_response     = array();
        $obj_sub_category = CategoryModel::with(['translations','units'])->where('parent',$category_id)->get();

        if($obj_sub_category != FALSE)
        {
            $arr_sub_category =  $obj_sub_category->toArray();
        }

        if(sizeof($arr_sub_category)>0)
        {
            $arr_response['status']           = "SUCCESS";
            $arr_response['arr_sub_category'] = $arr_sub_category;
        }
        else
        {
            $arr_response['status']           = "ERROR";
            $arr_response['arr_sub_category'] = array();
        }

        $obj_units = CategoryModel::with(['units'])->where('id',$category_id)->get();

        if($obj_units != FALSE)
        {
            $arr_units =  $obj_units->toArray();
        }

        if(sizeof($arr_units)>0)
        {
            $arr_response['status']    = "SUCCESS";
            $arr_response['arr_units'] = $arr_units;
        }
        else
        {
            $arr_response['status']     = "ERROR";
            $arr_response['arr_units'] = array();
        }

        return response()->json($arr_response);
    }

    public function get_goods($category_id)
    {
        $arr_goods    = array();
        $arr_response = array();
        $obj_goods    = VarietyModel::with(['translations'])->where('sub_category_id',$category_id)
                                                              ->get();

        if($obj_goods != FALSE)
        {
            $arr_goods =  $obj_goods->toArray();
        }

        if(sizeof($arr_goods)>0)
        {
            $arr_response['status']    = "SUCCESS";
            $arr_response['arr_goods'] = $arr_goods;
        }
        else
        {
            $arr_response['status']    = "ERROR";
            $arr_response['arr_goods'] = array();
        }
        return response()->json($arr_response);

    }
}
 

