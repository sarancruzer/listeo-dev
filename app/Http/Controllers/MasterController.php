<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use JWTAuth;


class MasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getToken($request)
    {
        $token = null; 
        foreach (getallheaders() as $name => $value) {
            if($name == "Authorization")
            {
                return $token = str_replace("Bearer ", "", $value);
            }
        }
        return response()->json(['error' => "Authentication Not Provided"],401);
    }

    public function getMasterDetails(Request $request){
        //  $token = $this->getToken($request);
        //  $user = JWTAuth::toUser($token);
         $input = $request->all();
        foreach ($input as $key => $value) {
            $lists[$value] = DB::table($value)->orderby('id')->get();
        }
         $result['info'] = $lists;
         return response()->json(['result' => $result]);


    }
    
      public function getAmenities(Request $request){
        //  $token = $this->getToken($request);
        //  $user = JWTAuth::toUser($token);
         $input = $request->all();
        
        $lists = DB::table('m_amenities')
        ->where('name','like',$input['q']."%")
        ->orderBy('id','desc')
        ->paginate($this->list_count);        
       
        $result = array();
        if(count($lists) > 0){
             $result["info"] = $lists;
             return response()->json(["result" => $result]);   
        }
        return response()->json(['error'=>"No records found!"],401);

    }

    public function submitMasterAmenities(Request $request){
        // $token = $this->getToken($request);
        // $user = JWTAuth::toUser($token);
        $input = $request->all();

        $count = count($input["info"]);
        if(!$count){
            return response()->json(['error'=>"Invalid Entry"],401);
        }
        $input_data = $input["info"];
        $data['name'] = $input_data['name'];


    if(isset($input_data['id']) && $input_data['id'] != '' ){
         $checkData = DB::table('m_amenities')
            ->where('id','!=',$input_data['id'])
            ->where('name','=',$input_data['name'])
            ->select('name')
            ->first($data);
    
            if($checkData){
                 return response()->json(['error'=>"Already exists!"],401);
            }
    }else{

        $checkData = DB::table('m_amenities')
            ->where('name','=',$input_data['name'])
            ->select('name')
            ->first($data);
            if($checkData){
                 return response()->json(['error'=>"Already exists!"],401);
            }
    }
     
        if(isset($input_data['id']) && $input_data['id'] != '' ){
            $listId = DB::table('m_amenities')
            ->where('id','=',$input_data['id'])
            ->update($data);
            $res_msg = "Your record has been updated sucessfully";
        }else{
             $listId = DB::table('m_amenities')->insertGetId($data);
            $res_msg = "Your record has been inserted sucessfully";
        }
        

        $result = array();
        if(count($listId) > 0){
             $result["msg"] = $res_msg;
             return response()->json(["result" => $result]);   
        }
        return response()->json(['error'=>"No records found!"],401);
           
    }

    public function getCategory(Request $request){
        //  $token = $this->getToken($request);
        //  $user = JWTAuth::toUser($token);
         $input = $request->all();
        
        $lists = DB::table('m_category')
        ->where('name','like',$input['q']."%")
        ->orderBy('id','desc')
        ->paginate($this->list_count);        
       
        $result = array();
        if(count($lists) > 0){
             $result["info"] = $lists;
             return response()->json(["result" => $result]);   
        }
        return response()->json(['error'=>"No records found!"],401);

    }

    public function submitMasterCategory(Request $request){
        // $token = $this->getToken($request);
        // $user = JWTAuth::toUser($token);
        $input = $request->all();

        $count = count($input["info"]);
        if(!$count){
            return response()->json(['error'=>"Invalid Entry"],401);
        }
        $input_data = $input["info"];
        $data['name'] = $input_data['name'];


    if(isset($input_data['id']) && $input_data['id'] != '' ){
         $checkData = DB::table('m_category')
            ->where('id','!=',$input_data['id'])
            ->where('name','=',$input_data['name'])
            ->select('name')
            ->first($data);
    
            if($checkData){
                 return response()->json(['error'=>"Already exists!"],401);
            }
    }else{

        $checkData = DB::table('m_category')
            ->where('name','=',$input_data['name'])
            ->select('name')
            ->first($data);
            if($checkData){
                 return response()->json(['error'=>"Already exists!"],401);
            }
    }
     
        if(isset($input_data['id']) && $input_data['id'] != '' ){
            $listId = DB::table('m_category')
            ->where('id','=',$input_data['id'])
            ->update($data);
            $res_msg = "Your record has been updated sucessfully";
        }else{
             $listId = DB::table('m_category')->insertGetId($data);
            $res_msg = "Your record has been inserted sucessfully";
        }
        

        $result = array();
        if(count($listId) > 0){
             $result["msg"] = $res_msg;
             return response()->json(["result" => $result]);   
        }
        return response()->json(['error'=>"No records found!"],401);
           
    }

     public function getCity(Request $request){
        //  $token = $this->getToken($request);
        //  $user = JWTAuth::toUser($token);
         $input = $request->all();
        
        $lists = DB::table('m_category')
        ->where('name','like',$input['q']."%")
        ->orderBy('id','desc')
        ->paginate($this->list_count);        
       
        $result = array();
        if(count($lists) > 0){
             $result["info"] = $lists;
             return response()->json(["result" => $result]);   
        }
        return response()->json(['error'=>"No records found!"],401);

    }

    public function submitMasterCity(Request $request){
        // $token = $this->getToken($request);
        // $user = JWTAuth::toUser($token);
        $input = $request->all();

        $count = count($input["info"]);
        if(!$count){
            return response()->json(['error'=>"Invalid Entry"],401);
        }
        $input_data = $input["info"];
        $data['name'] = $input_data['name'];


    if(isset($input_data['id']) && $input_data['id'] != '' ){
         $checkData = DB::table('m_city')
            ->where('id','!=',$input_data['id'])
            ->where('name','=',$input_data['name'])
            ->select('name')
            ->first($data);
    
            if($checkData){
                 return response()->json(['error'=>"Already exists!"],401);
            }
    }else{

        $checkData = DB::table('m_city')
            ->where('name','=',$input_data['name'])
            ->select('name')
            ->first($data);
            if($checkData){
                 return response()->json(['error'=>"Already exists!"],401);
            }
    }
     
        if(isset($input_data['id']) && $input_data['id'] != '' ){
            $listId = DB::table('m_city')
            ->where('id','=',$input_data['id'])
            ->update($data);
            $res_msg = "Your record has been updated sucessfully";
        }else{
             $listId = DB::table('m_city')->insertGetId($data);
            $res_msg = "Your record has been inserted sucessfully";
        }
        

        $result = array();
        if(count($listId) > 0){
             $result["msg"] = $res_msg;
             return response()->json(["result" => $result]);   
        }
        return response()->json(['error'=>"No records found!"],401);
           
    }

     public function getState(Request $request){
        //  $token = $this->getToken($request);
        //  $user = JWTAuth::toUser($token);
         $input = $request->all();
        
        $lists = DB::table('m_state')
        ->where('name','like',$input['q']."%")
        ->orderBy('id','desc')
        ->paginate($this->list_count);        
       
        $result = array();
        if(count($lists) > 0){
             $result["info"] = $lists;
             return response()->json(["result" => $result]);   
        }
        return response()->json(['error'=>"No records found!"],401);

    }

    public function submitMasterState(Request $request){
        // $token = $this->getToken($request);
        // $user = JWTAuth::toUser($token);
        $input = $request->all();

        $count = count($input["info"]);
        if(!$count){
            return response()->json(['error'=>"Invalid Entry"],401);
        }
        $input_data = $input["info"];
        $data['name'] = $input_data['name'];


    if(isset($input_data['id']) && $input_data['id'] != '' ){
         $checkData = DB::table('m_state')
            ->where('id','!=',$input_data['id'])
            ->where('name','=',$input_data['name'])
            ->select('name')
            ->first($data);
    
            if($checkData){
                 return response()->json(['error'=>"Already exists!"],401);
            }
    }else{

        $checkData = DB::table('m_state')
            ->where('name','=',$input_data['name'])
            ->select('name')
            ->first($data);
            if($checkData){
                 return response()->json(['error'=>"Already exists!"],401);
            }
    }
     
        if(isset($input_data['id']) && $input_data['id'] != '' ){
            $listId = DB::table('m_state')
            ->where('id','=',$input_data['id'])
            ->update($data);
            $res_msg = "Your record has been updated sucessfully";
        }else{
             $listId = DB::table('m_state')->insertGetId($data);
            $res_msg = "Your record has been inserted sucessfully";
        }
        

        $result = array();
        if(count($listId) > 0){
             $result["msg"] = $res_msg;
             return response()->json(["result" => $result]);   
        }
        return response()->json(['error'=>"No records found!"],401);
           
    }

      public function getTime(Request $request){
        //  $token = $this->getToken($request);
        //  $user = JWTAuth::toUser($token);
         $input = $request->all();
        
        $lists = DB::table('m_time')
        ->where('name','like',$input['q']."%")
        ->orderBy('id','desc')
        ->paginate($this->list_count);        
       
        $result = array();
        if(count($lists) > 0){
             $result["info"] = $lists;
             return response()->json(["result" => $result]);   
        }
        return response()->json(['error'=>"No records found!"],401);

    }

    public function submitMasterTime(Request $request){
        // $token = $this->getToken($request);
        // $user = JWTAuth::toUser($token);
        $input = $request->all();

        $count = count($input["info"]);
        if(!$count){
            return response()->json(['error'=>"Invalid Entry"],401);
        }
        $input_data = $input["info"];
        $data['name'] = $input_data['name'];


    if(isset($input_data['id']) && $input_data['id'] != '' ){
         $checkData = DB::table('m_time')
            ->where('id','!=',$input_data['id'])
            ->where('name','=',$input_data['name'])
            ->select('name')
            ->first($data);
    
            if($checkData){
                 return response()->json(['error'=>"Already exists!"],401);
            }
    }else{

        $checkData = DB::table('m_time')
            ->where('name','=',$input_data['name'])
            ->select('name')
            ->first($data);
            if($checkData){
                 return response()->json(['error'=>"Already exists!"],401);
            }
    }
     
        if(isset($input_data['id']) && $input_data['id'] != '' ){
            $listId = DB::table('m_time')
            ->where('id','=',$input_data['id'])
            ->update($data);
            $res_msg = "Your record has been updated sucessfully";
        }else{
             $listId = DB::table('m_time')->insertGetId($data);
            $res_msg = "Your record has been inserted sucessfully";
        }
        

        $result = array();
        if(count($listId) > 0){
             $result["msg"] = $res_msg;
             return response()->json(["result" => $result]);   
        }
        return response()->json(['error'=>"No records found!"],401);
           
    }

     public function getWeekdays(Request $request){
        //  $token = $this->getToken($request);
        //  $user = JWTAuth::toUser($token);
         $input = $request->all();
        
        $lists = DB::table('m_weekdays')
        ->where('name','like',$input['q']."%")
        ->orderBy('id','desc')
        ->paginate($this->list_count);        
       
        $result = array();
        if(count($lists) > 0){
             $result["info"] = $lists;
             return response()->json(["result" => $result]);   
        }
        return response()->json(['error'=>"No records found!"],401);

    }

    public function submitMasterWeekdays(Request $request){
        // $token = $this->getToken($request);
        // $user = JWTAuth::toUser($token);
        $input = $request->all();

        $count = count($input["info"]);
        if(!$count){
            return response()->json(['error'=>"Invalid Entry"],401);
        }
        $input_data = $input["info"];
        $data['name'] = $input_data['name'];


    if(isset($input_data['id']) && $input_data['id'] != '' ){
         $checkData = DB::table('m_weekdays')
            ->where('id','!=',$input_data['id'])
            ->where('name','=',$input_data['name'])
            ->select('name')
            ->first($data);
    
            if($checkData){
                 return response()->json(['error'=>"Already exists!"],401);
            }
    }else{

        $checkData = DB::table('m_weekdays')
            ->where('name','=',$input_data['name'])
            ->select('name')
            ->first($data);
            if($checkData){
                 return response()->json(['error'=>"Already exists!"],401);
            }
    }
     
        if(isset($input_data['id']) && $input_data['id'] != '' ){
            $listId = DB::table('m_weekdays')
            ->where('id','=',$input_data['id'])
            ->update($data);
            $res_msg = "Your record has been updated sucessfully";
        }else{
             $listId = DB::table('m_weekdays')->insertGetId($data);
            $res_msg = "Your record has been inserted sucessfully";
        }
        

        $result = array();
        if(count($listId) > 0){
             $result["msg"] = $res_msg;
             return response()->json(["result" => $result]);   
        }
        return response()->json(['error'=>"No records found!"],401);
           
    }

}
