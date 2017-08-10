<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListingController extends Controller
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

    public function index()
    {
        //
        //  $token = $this->getToken($request);
        //  $user = JWTAuth::toUser($token);
        $input = $request->all();
        
        $lists = DB::table('listings')
                        ->where('name','like',$input['q']."%")
                        ->where('id','=',0)
                        ->orderBy('id','desc')
                        ->paginate($this->list_count);        
       
        $result = array();
        if(count($lists) > 0){
             $result["info"] = $lists;
             return response()->json(["result" => $result]);   
        }
        return response()->json(['error'=>"No records found!"],401);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $token = $this->getToken($request);
    	$user = JWTAuth::toUser($token);
        $input = $request->all();

        $d = $input['info'];
        $data['business_name'] = $d['business_name'];
        $data['category'] = $d['category'];
        $data['keywords'] = $d['keywords'];
        $data['city'] = $d['city'];
        $data['address'] = $d['address'];
        $data['state'] = $d['state'];
        $data['zipcode'] = $d['zipcode'];
        $data['description'] = $d['description'];
        $data['phone'] = $d['phone'];
        $data['website'] = $d['website'];
        $data['email'] = $d['email'];
        $data['facebook_link'] = $d['facebook_link'];
        $data['twitter_link'] = $d['twitter_link'];
        $data['googleplus_link'] = $d['googleplus_link'];
        

        $listingId = DB::table('listings')->insertGetId($data);

        $this->insertOtherListings($input , $listingId);

        if($listingId){
            $result['result'] = 'Your listing has been inserted successfully';
            return response()->json(['result'=>$result]);
        }
        return response()->json(['result'=>'Your listing has been coud not added!'],401);
        
    }


    public function insertOtherListings($input , $listingId){

        $data = $input['info'];
        if(isset($data['amenities']) && !empty($data['amenities'])){

             foreach ($data['amenities'] as $key => $value) {
                $a_data['listing_id'] = $listingId;
                $a_data['amenities'] = $value['amenities'];
                          
                $a_id = DB::table('listings_amenities')->insertGetId($a_data);             
            }
        }

        if(isset($data['opening_hours']) && !empty($data['opening_hours'])){

             foreach ($data['opening_hours'] as $key => $value) {
                $o_data['listing_id'] = $listingId;
                $o_data['weekdays'] = $value['weekdays'];
                $o_data['opening_time'] = $value['opening_time'];
                $o_data['closing_time'] = $value['closing_time'];
                          
                $o_id = DB::table('listings_opening_hours')->insertGetId($o_data);             
            }
        }
                                          

         if($request->hasFile('logo')){

             foreach ($data['gallery'] as $key => $value) {

                $destinationPath = 'uploads/gallery/'.$input["info"]["company"];
                $file = $request->file('logo');
                $upfile = $file->move($destinationPath,$file->getClientOriginalName());

                $company["logo"] = $destinationPath."/".$file->getClientOriginalName();

                $g_data['listing_id'] = $listingId;
                $g_data['image_path'] = $value['image_path'];
                
                $o_id = DB::table('listings_opening_hours')->insertGetId($g_data);  

             }
        }

        if(isset($data['pricing_category']) && !empty($data['pricing_category'])){

             foreach ($data['pricing_category'] as $key => $value) {
                $pc_data['listing_id'] = $listingId;
                $pc_data['category_name'] = $value['category_name'];
                          
                $pc_id = DB::table('listing_pricing_category')->insertGetId($pc_data);             


                 if(isset($value['pricing_services']) && !empty($data['pricing_services'])){

                        foreach ($value['pricing_services'] as $k => $val) {
                        $ps_data['listing_id'] = $listingId;
                        $ps_data['listing_pricing_id'] = $pc_id;
                        $ps_data['title'] = $val['title'];
                        $ps_data['description'] = $val['description'];  
                        $ps_data['price'] = $val['price'];
                          
                        $a_id = DB::table('listing_pricing_services')->insertGetId($ps_data);             
                    }   
                 }
            }
            
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , $id)
    {
        //

        $lists = DB::table('listings')->first();

        $l_amenities = DB::table('listings_amenities')
                    ->where('listing_id','=',$lists->id)
                    ->get();
        $l_gallery = DB::table('listings_gallery')
                    ->where('listing_id','=',$lists->id)
                    ->get();
        $l_opening_hours = DB::table('listings_opening_hours')
                    ->where('listing_id','=',$lists->id)
                    ->get();
        $l_reviews = DB::table('listings_reviews')
                    ->where('listing_id','=',$lists->id)
                    ->get();
        $l_pricing_category = DB::table('listing_pricing_category')
                    ->where('listing_id','=',$lists->id)
                    ->get();                    
        $l_reviews = DB::table('listing_pricing_services')
                    ->where('listing_id','=',$lists->id)
                    ->get();

         if(count($lists)>0){
            $result['result']['lists'] = $lists;
            $result['result']['l_amenities'] = $l_amenities;
            $result['result']['l_gallery'] = $l_gallery;
            $result['result']['l_opening_hours'] = $l_opening_hours;
            $result['result']['l_reviews'] = $l_reviews;
            return response()->json(['result'=>$result]);
        }
        return response()->json(['result'=>'Your listing has been coud not added!'],401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request , $id)
    {
        //
        $token = $this->getToken($request);
    	$user = JWTAuth::toUser($token);
        $input = $request->all();

        $lists = DB::table('listings')->first();

        $l_amenities = DB::table('listings_amenities')
                    ->where('listing_id','=',$lists->id)
                    ->get();
        $l_gallery = DB::table('listings_gallery')
                    ->where('listing_id','=',$lists->id)
                    ->get();
        $l_opening_hours = DB::table('listings_opening_hours')
                    ->where('listing_id','=',$lists->id)
                    ->get();
        $l_reviews = DB::table('listings_reviews')
                    ->where('listing_id','=',$lists->id)
                    ->get();
        $l_pricing_category = DB::table('listing_pricing_category')
                    ->where('listing_id','=',$lists->id)
                    ->get();                    
        $l_reviews = DB::table('listing_pricing_services')
                    ->where('listing_id','=',$lists->id)
                    ->get();

         if(count($lists)>0){
            $result['result']['lists'] = $lists;
            $result['result']['l_amenities'] = $l_amenities;
            $result['result']['l_gallery'] = $l_gallery;
            $result['result']['l_opening_hours'] = $l_opening_hours;
            $result['result']['l_reviews'] = $l_reviews;
            return response()->json(['result'=>$result]);
        }
        return response()->json(['result'=>'Your listing has been coud not added!'],401);
                    


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

        $token = $this->getToken($request);
    	$user = JWTAuth::toUser($token);
        $input = $request->all();

        $d = $input['info'];
        $data['business_name'] = $d['business_name'];
        $data['category'] = $d['category'];
        $data['keywords'] = $d['keywords'];
        $data['city'] = $d['city'];
        $data['address'] = $d['address'];
        $data['state'] = $d['state'];
        $data['zipcode'] = $d['zipcode'];
        $data['description'] = $d['description'];
        $data['phone'] = $d['phone'];
        $data['website'] = $d['website'];
        $data['email'] = $d['email'];
        $data['facebook_link'] = $d['facebook_link'];
        $data['twitter_link'] = $d['twitter_link'];
        $data['googleplus_link'] = $d['googleplus_link'];
        

        $listingId = DB::table('listings')->where('id','=',$id)->update($data);

        $this->updateOtherListings($input , $id);

        if($listingId){
            $result['result'] = 'Your listing has been updated successfully';
            return response()->json(['result'=>$result]);
        }
        return response()->json(['result'=>'Your listing has been coud not updated!'],401);
    }

     public function updateOtherListings($input , $listingId){

        $data = $input['info'];
        if(isset($data['amenities']) && !empty($data['amenities'])){
            DB::table('listings_amenities')->where('listing_id','=',$listingId)->delete();
             foreach ($data['amenities'] as $key => $value) {
                $a_data['listing_id'] = $listingId;
                $a_data['amenities'] = $value['amenities'];
                          
                $a_id = DB::table('listings_amenities')->where('listing_id','=',$listingId)->update($a_data);             
            }
        }

        if(isset($data['opening_hours']) && !empty($data['opening_hours'])){
            DB::table('listings_opening_hours')->where('listing_id','=',$listingId)->delete();
             foreach ($data['opening_hours'] as $key => $value) {
                $o_data['listing_id'] = $listingId;
                $o_data['weekdays'] = $value['weekdays'];
                $o_data['opening_time'] = $value['opening_time'];
                $o_data['closing_time'] = $value['closing_time'];
                          
                $o_id = DB::table('listings_opening_hours')->where('listing_id','=',$listingId)->update($o_data);             
            }
        }
                                          

         if($request->hasFile('logo')){
             
             DB::table('listings_gallery')->where('listing_id','=',$listingId)->delete();

             foreach ($data['gallery'] as $key => $value) {
                
                $destinationPath = 'uploads/'.$input["info"]["company"];
                $file = $request->file('logo');
                $upfile = $file->move($destinationPath,$file->getClientOriginalName());

                $company["logo"] = $destinationPath."/".$file->getClientOriginalName();

                $g_data['listing_id'] = $listingId;
                $g_data['image_path'] = $value['image_path'];
                
                $o_id = DB::table('listings_gallery')->where('listing_id','=',$listingId)->update($o_data);               

             }
        }
     


        if(isset($data['pricing_category']) && !empty($data['pricing_category'])){
             DB::table('listing_pricing_category')->where('listing_id','=',$listingId)->delete();

             foreach ($data['pricing_category'] as $key => $value) {
                $pc_data['listing_id'] = $listingId;
                $pc_data['category_name'] = $value['category_name'];
                          
                $pc_id = DB::table('listing_pricing_category')->where('listing_id','=',$listingId)->update($pc_data);             


                 if(isset($value['pricing_services']) && !empty($data['pricing_services'])){
                DB::table('listing_pricing_services')->where('listing_id','=',$listingId)->delete();
                        foreach ($value['pricing_services'] as $k => $val) {
                        $ps_data['listing_id'] = $listingId;
                        $ps_data['listing_pricing_id'] = $pc_id;
                        $ps_data['title'] = $val['title'];
                        $ps_data['description'] = $val['description'];  
                        $ps_data['price'] = $val['price'];
                          
                        $a_id = DB::table('listing_pricing_services')->where('listing_id','=',$listingId)->update($ps_data);             
                    }   
                 }
            }
            
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , $id)
    {
        //
        $token = $this->getToken($request);
    	$user = JWTAuth::toUser($token);
        $input = $request->all();

        $data['is_deleted'] = 1;
        $del_id = DB::table('listings')->where('id','=',$id)->update($data);  

        if($del_id){
            $result['result'] = 'Your listing has been deleted successfully';
            return response()->json(['result'=>$result]);
        }
        return response()->json(['result'=>'Your listing has been coud not deleted!'],401);

    }
}
