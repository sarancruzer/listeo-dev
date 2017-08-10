<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $input = $request->all();
    
        $d = $input['info'];
        $data['name'] = $d['username'];
        $data['email'] = $d['email'];
        $data['user_type'] = "user";
        $data['password'] = Hash::make($d['password']);
        
        $regId = DB::table('users')->insertGetId($data);
        if($regId){
            $result['result'] = 'Your registration has been completed';
            return response()->json(['result'=>$result]);
        }
        return response()->json(['result'=>'Your registration failed!!'],401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $input = $request->all();
    
        $d = $input['info'];
        $data['name'] = $d['username'];
        $data['email'] = $d['email'];
        $data['mobile'] = $d['email'];
        $data['notes'] = $d['notes'];
        $data['twitter_link'] = $d['twitter_link'];
        $data['facebook_link'] = $d['facebook_link'];
        $data['googleplus_link'] = $d['googleplus_link'];
       
        $data['avatar'] = '';
        if($request->hasFile('avatar')){
                $destinationPath = 'uploads/avatar/'.$input["info"]["company"];
                $file = $request->file('avatar');
                $upfile = $file->move($destinationPath,$file->getClientOriginalName());
                $data["avatar"] = $destinationPath."/".$file->getClientOriginalName();
        }

        $profileId = DB::table('users')->insertGetId($data);
        if($profileId){
            $result['result'] = 'Your profile has been updated successfully! ';
            return response()->json(['result'=>$result]);
        }
        return response()->json(['result'=>'Your profile update failed!!'],401);
    }

    public function changePassword(Request $request)
    {
        //
        $token = $this->getToken($request);
    	$user = JWTAuth::toUser($token);
    	$data = $request->all();
    	
    	$id = $user->id;
        $d = $input['info'];
    	$current_password_db = $user->password;
    	$current_password = $d['current_password'];
    	$new_password = $d['new_password'];
    	$confirm_password = $d['confirm_password'];
    	
    	if(!Hash::check($current_password, $user->password)){
    		return response()->json(['error'=>'Incorrect Current Password'], 401);
    	}
    	if($new_password != $confirm_password){
    		return response()->json(['error'=>'Confirm Password and New Password did not match'],401);
    	}

    	$new_password = Hash::make($new_password);
    	User::where('id', $id)->update(['password' => $new_password]);
        
    	return response()->json(["result"=>"Password Changed Successfully","user"=>$user,"pwd"=>$user->password]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
