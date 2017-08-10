<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //  $token = $this->getToken($request);
        //  $user = JWTAuth::toUser($token);
        $input = $request->all();
        
        $lists = DB::table('listings_reviews as lr')
                        ->leftjoin('listings as l','l.id','=','lr.listing_id')
                        ->select('lr.*','l.business_name')
                        ->where('l.name','like',$input['q']."%")
                        ->where('lr.id','=',0)
                        ->where(function($query) use ($input)
                        {
                            if($input['listing'] > 0){
                                $query->where('lr.listing_id','=', $input['listing']);
                            }
                        })
                        ->orderBy('lr.id','desc')
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
        $data['listing_id'] = $d['listing_id'];
        $data['name'] = $d['name'];
        $data['email'] = $d['email'];
        $data['review'] = $d['review'];
        $data['star_rating'] = $d['star_rating'];
        $data['img_path'] = $d['img_path'];
        
        $reviewId = DB::table('listings_reviews')->insertGetId($data);

        if($reviewId){
            $result['result'] = 'Your review has been sent successfully';
            return response()->json(['result'=>$result]);
        }
        return response()->json(['result'=>'Your review has been coud not sent!'],401);
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
