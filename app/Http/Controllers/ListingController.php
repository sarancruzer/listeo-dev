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


     if($request->hasFile('banner')){

                                            $banner_destination_path    ="uploads/vendor/banner/";
                                            $banners = $request->file("banner");
                                            foreach ( $banners as $key => $banner) {

                                                $banner_file_name             =time().$banner->getClientOriginalName(); 
                                                    if(!$banner->move($banner_destination_path,$banner_file_name))
                                                    {

                                                     $status =['error'=>"Can't upload banner"];
                                                     $status_code =401;
                                                     return response()->json($status,$status_code);

                                                    }else{

                                                        $banners_path[] =$banner_destination_path.$banner_file_name;

                                                    }
                                                    # code...
                                                }           

                                            }
                                            

         if($request->hasFile('logo')){

             foreach ($data['gallery'] as $key => $value) {

                $destinationPath = 'uploads/'.$input["info"]["company"];
                $file = $request->file('logo');
                $upfile = $file->move($destinationPath,$file->getClientOriginalName());

                $company["logo"] = $destinationPath."/".$file->getClientOriginalName();

                $g_data['listing_id'] = $listingId;
                $g_data['image_path'] = $value['image_path'];
                
                $o_id = DB::table('listings_opening_hours')->insertGetId($g_data);  

             }
        }


        if(isset($data['gallery']) && !empty($data['gallery'])){

             foreach ($data['opening_hours'] as $key => $value) {
                $o_data['listing_id'] = $listingId;
                $o_data['weekdays'] = $value['weekdays'];
                $o_data['opening_time'] = $value['opening_time'];
                $o_data['closing_time'] = $value['closing_time'];
                          
                $a_id = DB::table('listings_opening_hours')->insertGetId($o_data);             
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
    

     if($request->hasFile('gallery')){

        $galler_destination_path    ="uploads/gallery/";
        $gallery = $request->file("gallery");
        foreach ( $gallery as $key => $galler) {
            $galler_file_name             =time().$galler->getClientOriginalName(); 
                if(!$galler->move($galler_destination_path,$galler_file_name))
                {
                    $status =['error'=>"Can't upload banner"];
                    $status_code =401;
                    return response()->json($status,$status_code);

                }else{

                    $galler_path[] =$galler_destination_path.$galler_file_name;
                }

            }  

             foreach ($galler_path as $key => $galler_pth) {
                    $g_data['listing_id'] = $listingId;
                    $g_data['image_path'] = $galler_pth;

                    DB::table('listings_opening_hours')->insertGetId($g_data);
                 }         

        }




         if($request->hasFile('logo')){

             foreach ($data['gallery'] as $key => $value) {

                $destinationPath = 'uploads/'.$input["info"]["company"];
                $file = $request->file('logo');
                $upfile = $file->move($destinationPath,$file->getClientOriginalName());

                $company["logo"] = $destinationPath."/".$file->getClientOriginalName();

                $g_data['listing_id'] = $listingId;
                $g_data['image_path'] = $value['image_path'];
                
                $o_id = DB::table('listings_opening_hours')->insertGetId($g_data);  

             }
        }


        if(isset($data['gallery']) && !empty($data['gallery'])){

             foreach ($data['opening_hours'] as $key => $value) {
                $o_data['listing_id'] = $listingId;
                $o_data['weekdays'] = $value['weekdays'];
                $o_data['opening_time'] = $value['opening_time'];
                $o_data['closing_time'] = $value['closing_time'];
                          
                $a_id = DB::table('listings_opening_hours')->insertGetId($o_data);             
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
